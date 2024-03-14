<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\BondsModel;
use App\Models\InvoiceItemsModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOfferSalesItemsModel;
use App\Models\PriceOfferSalesModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountStatementController extends Controller
{
    public function customer_account_statement_index(){
        return view('admin.accounting.account_statement.customer_account_statement_index');
    }

    public function list_customers_table_ajax(Request $request){
        $data = User::whereJsonContains('user_role','10')->when($request->filled('search_input'),function ($query) use ($request){
            $query->where('name','like','%'.$request->search_input.'%')->get();
        })->get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.account_statement.ajax.list_customers_table',['data'=>$data])->render()
        ]);
    }

    public function account_statement_details($id,$user_type){
        $user = User::find($id);
        return view('admin.accounting.account_statement.account_statement_details',['user'=>$user,'user_type'=>$user_type]);
    }

    public function account_statement_details_table_ajax(Request $request){
//        $invoicesQuery = PurchaseInvoicesModel::select('bfo_invoices.id as i_id', 'bfo_invoices.created_at', 'bfo_invoices.invoice_type')
//            ->where('bfo_invoices.client_id',$request->user_id)
//            ->selectRaw('SUM(bfo_invoice_items.rate) as total_rate')
//            ->join('bfo_invoice_items', 'bfo_invoices.id', '=', 'bfo_invoice_items.invoice_id')
//            ->groupBy('bfo_invoices.id', 'bfo_invoices.created_at', 'bfo_invoices.invoice_type')
//            ->get();
        $invoicesQuery = DB::table('bfo_invoices')
            ->select('id as i_id', 'client_id', 'created_at', 'invoice_type', DB::raw('NULL as amount'))
            ->where('client_id', $request->user_id)
            ->selectSub(function ($query) {
                $query->selectRaw('SUM(rate * quantity)')
                    ->from('bfo_invoice_items')
                    ->whereColumn('bfo_invoice_items.invoice_id', 'bfo_invoices.id');
            }, 'total_rate');

        $bondsQuery = DB::table('bonds')
            ->select('invoice_id as i_id', 'amount as total_rate', 'invoice_type', 'created_at')
            ->whereIn('invoice_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('bfo_invoices')
                    ->whereIn('client_id', function ($query) use ($request) {
                        $query->select('id')
                            ->from('users')
                            ->where('id', $request->user_id);
                    });
            });



        $invoicesResult = $invoicesQuery->get();
        $bondsResult = $bondsQuery->get();


        $data = $invoicesResult->concat($bondsResult);

        if (!empty($request->from) && !empty($request->to)) {
            // Apply filtering logic only when both $request->from and $request->to are not empty
            $data = $data->filter(function ($item) use ($request) {
                // Get created_at value, use a default date if it's null
                $createdAt = $item->created_at ?? now();

                // Modify the condition as per your requirement
                return $createdAt >= $request->from && $createdAt <= $request->to;
            });
        }

        $invoicesQuery = DB::table('bfo_invoices')
            ->select('invoice_type', DB::raw('COUNT(*) as count'))
            ->where('client_id', $request->user_id)
            ->groupBy('invoice_type')
            ->get();

        $bondsQuery = DB::table('bonds')
            ->select('invoice_type', DB::raw('COUNT(*) as count'))
            ->whereIn('invoice_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('bfo_invoices')
                    ->whereIn('client_id', function ($query) use ($request) {
                        $query->select('id')
                            ->from('users')
                            ->where('id', $request->user_id);
                    });
            })
            ->groupBy('invoice_type')
            ->get();

        $invoiceCounts = $invoicesQuery->concat($bondsQuery);

        if (!empty($data)) {
            $data = $data->sortBy('created_at')->values()->all();
        }

        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.account_statement.ajax.account_statement_details_table',['data'=>$data,'invoiceCounts'=>$invoiceCounts])->render()
        ]);
    }
}
