<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect('login');
    }
});


Auth::routes();
// Purchases System //
Route::group(['middleware' => 'auth',], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class,'index'])->name('home');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/index', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::post('/updateStatus', [App\Http\Controllers\UserController::class, 'updateStatus'])->name('users.updateStatus');
        Route::get('add_form',[App\Http\Controllers\UserController::class, 'add_form'])->name('users.add_form');
        Route::post('create',[App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('update/{id}',[App\Http\Controllers\UserController::class, 'update'])->name('users.update');

        Route::group(['prefix' => 'procurement_officer'], function () {
            Route::get('/index', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'index'])->name('users.procurement_officer.index');
            Route::get('/add', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'add'])->name('users.procurement_officer.add');
            Route::post('create', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'create'])->name('users.procurement_officer.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'edit'])->name('users.procurement_officer.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'update'])->name('users.procurement_officer.update');
            Route::get('details/{id}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'details'])->name('users.procurement_officer.details');

            Route::group(['prefix' => 'tasks'], function () {
                Route::get('/index', [App\Http\Controllers\procurement_officer\tasks\TasksController::class, 'index'])->name('procurement_officer.tasks.index');
            });
            // TODO طلبات الشراء
            Route::group(['prefix' => 'orders'], function () {
                Route::get('/index', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'orders_index'])->name('orders.procurement_officer.order_index');
                Route::get('/order_items_index/{order_id}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'order_items_index'])->name('orders.procurement_officer.order_items_index');
                Route::post('/create_order', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'create_order'])->name('orders.procurement_officer.create_order');
                Route::post('/order_table', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'order_table'])->name('orders.procurement_officer.order_table');
                Route::get('/listOrderForOfficerIndex', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'listOrderForOfficerIndex'])->name('orders.procurement_officer.listOrderForOfficerIndex');
                Route::post('/listOrderForOfficer', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'listOrderForOfficer'])->name('orders.procurement_officer.listOrderForOfficer');
                Route::post('/update_reference_number', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'update_reference_number'])->name('orders.procurement_officer.update_reference_number');
                Route::get('/getReferenceNumber', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'getReferenceNumber'])->name('orders.procurement_officer.getReferenceNumber');
                Route::get('/show_due_date', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'show_due_date'])->name('orders.procurement_officer.show_due_date');
                Route::post('/update_due_date', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'update_due_date'])->name('orders.procurement_officer.update_due_date');
                Route::get('/delete_order/{id}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'delete_order'])->name('orders.procurement_officer.delete_order');
                Route::get('/list_orders_from_storekeeper', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'list_orders_from_storekeeper'])->name('orders.procurement_officer.list_orders_from_storekeeper');
                Route::post('/updateOrderStatus', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'updateOrderStatus'])->name('orders.procurement_officer.updateOrderStatus');
                Route::post('/updateToUser', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'updateToUser'])->name('orders.procurement_officer.updateToUser');
                Route::group(['prefix'=>'order_archive'],function(){
                    Route::get('index', [App\Http\Controllers\OrderArchiveController::class, 'index'])->name('order_archive.index');
                    Route::post('archive_order_table', [App\Http\Controllers\OrderArchiveController::class, 'archive_order_table'])->name('order_archive.archive_order_table');
                    Route::post('update_reference_number', [App\Http\Controllers\OrderArchiveController::class, 'update_reference_number'])->name('order_archive.update_reference_number');
                    Route::post('update_due_date', [App\Http\Controllers\OrderArchiveController::class, 'update_due_date'])->name('order_archive.update_due_date');
                });
                Route::group(['prefix'=>'product'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\ProductController::class, 'index'])->name('procurement_officer.orders.product.index');
                    Route::post('/create_order_items', [App\Http\Controllers\procurement_officer\ProductController::class, 'create_order_items'])->name('procurement_officer.orders.create_order_items');
                    Route::get('/product_list_pdf/{order_id}', [App\Http\Controllers\procurement_officer\ProductController::class, 'product_list_pdf'])->name('procurement_officer.orders.product.product_list_pdf');
                    Route::post('/search_product_ajax', [App\Http\Controllers\procurement_officer\ProductController::class, 'search_product_ajax'])->name('procurement_officer.orders.product.search_product_ajax');
                    Route::post('/create_product_ajax', [App\Http\Controllers\procurement_officer\ProductController::class, 'create_product_ajax'])->name('procurement_officer.orders.product.create_product_ajax');
                    Route::post('/order_items_table', [App\Http\Controllers\procurement_officer\ProductController::class, 'order_items_table'])->name('procurement_officer.orders.product.order_items_table');
                });
                Route::group(['prefix'=>'price_offer'],function(){
                    Route::get('index/{order_id}',[App\Http\Controllers\procurement_officer\PriceOfferController::class, 'index'])->name('procurement_officer.orders.price_offer.index');
                    Route::post('create_price_offer', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'create_price_offer'])->name('procurement_officer.orders.price_offer.create_price_offer');
                    Route::get('edit_price_offer/{id}', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'edit_price_offer'])->name('procurement_officer.orders.price_offer.edit_price_offer');
                    Route::post('update_price_offer/{id}', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'update_price_offer'])->name('procurement_officer.orders.price_offer.update_price_offer');
                    Route::get('details_offer_price/{id}', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'details_offer_price'])->name('procurement_officer.orders.price_offer.details_offer_price');
                    Route::get('delete_offer_price/{id}', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'delete_offer_price'])->name('procurement_officer.orders.price_offer.delete_offer_price');
                    Route::post('updateCurrency', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'updateCurrency'])->name('procurement_officer.orders.price_offer.updateCurrency');
                    Route::get('price_offer_export/{order_id}', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'exportExcel'])->name('procurement_officer.orders.price_offer.exportExcel');
                    Route::post('price_offer_import', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'importExcel'])->name('procurement_officer.orders.price_offer.importExcel');
                });
                Route::group(['prefix'=>'anchor'],function(){
                    Route::get('index/{order_id}',[App\Http\Controllers\procurement_officer\AnchorController::class, 'index'])->name('procurement_officer.orders.anchor.index');
                    Route::post('create_anchor', [App\Http\Controllers\procurement_officer\AnchorController::class, 'create_anchor'])->name('procurement_officer.orders.anchor.create_anchor');
                    Route::get('delete_anchor/{id}', [App\Http\Controllers\procurement_officer\AnchorController::class, 'delete_anchor'])->name('procurement_officer.orders.anchor.delete_anchor');
                    Route::post('updateNotesForAnchor', [App\Http\Controllers\procurement_officer\AnchorController::class, 'updateNotesForAnchor'])->name('procurement_officer.orders.anchor.updateNotesForAnchor');
                    Route::get('anchor_table_pdf/{order_id}/{price_offer}', [App\Http\Controllers\procurement_officer\AnchorController::class, 'anchor_table_pdf'])->name('procurement_officer.orders.anchor.anchor_table_pdf');
                    Route::get('compare_price_offers/{order_id}', [App\Http\Controllers\procurement_officer\AnchorController::class, 'compare_price_offers'])->name('procurement_officer.orders.anchor.compare_price_offers');
                    Route::post('upload_image', [App\Http\Controllers\procurement_officer\AnchorController::class, 'upload_image'])->name('procurement_officer.orders.anchor.upload_image');
                    Route::get('delete_attachment/{id}', [App\Http\Controllers\procurement_officer\AnchorController::class, 'delete_attachment'])->name('procurement_officer.orders.anchor.delete_attachment');
                });
                Route::group(['prefix'=>'financial_file'],function(){
                    Route::get('index/{order_id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'index'])->name('procurement_officer.orders.financial_file.index');
                    Route::post('create_cash_payment',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'create_cash_payment'])->name('procurement_officer.orders.financial_file.create_cash_payment');
                    Route::post('create_letter_bank',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'create_letter_bank'])->name('procurement_officer.orders.financial_file.create_letter_bank');
                    Route::get('edit_cash_payment/{id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'edit_cash_payment'])->name('procurement_officer.orders.financial_file.edit_cash_payment');
                    Route::post('update_cash_payment',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'update_cash_payment'])->name('procurement_officer.orders.financial_file.update_cash_payment');
                    Route::get('delete_cash_payment/{id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'delete_cash_payment'])->name('procurement_officer.orders.financial_file.delete_cash_payment');
                    Route::get('edit_letter_bank/{id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'edit_letter_bank'])->name('procurement_officer.orders.financial_file.edit_letter_bank');
                    Route::post('update_letter_bank',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'update_letter_bank'])->name('procurement_officer.orders.financial_file.update_letter_bank');
                    Route::get('delete_letter_bank/{id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'delete_letter_bank'])->name('procurement_officer.orders.financial_file.delete_letter_bank');
                    Route::get('extension_index/{letter_bank_id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'index_extension'])->name('procurement_officer.orders.financial_file.index_extension');
                    Route::post('create_extension',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'create_extension'])->name('procurement_officer.orders.financial_file.create_extension');
                    Route::get('edit_extension/{id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'edit_extension'])->name('procurement_officer.orders.financial_file.edit_extension');
                    Route::post('update_extension',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'update_extension'])->name('procurement_officer.orders.financial_file.update_extension');
                    Route::get('delete_extension/{id}',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'delete_extension'])->name('procurement_officer.orders.financial_file.delete_extension');
                    Route::post('updatePaymentStatus',[App\Http\Controllers\procurement_officer\FinancialFileController::class, 'updatePaymentStatus'])->name('procurement_officer.orders.financial_file.updatePaymentStatus');
                });
                Route::group(['prefix'=>'shipping'],function(){
                    Route::get('index/{order_id}',[App\Http\Controllers\procurement_officer\ShippingController::class, 'index'])->name('procurement_officer.orders.shipping.index');
                    Route::post('create',[App\Http\Controllers\procurement_officer\ShippingController::class, 'create'])->name('procurement_officer.orders.shipping.create');
                    Route::get('edit/{id}',[App\Http\Controllers\procurement_officer\ShippingController::class, 'edit'])->name('procurement_officer.orders.shipping.edit');
                    Route::post('update',[App\Http\Controllers\procurement_officer\ShippingController::class, 'update'])->name('procurement_officer.orders.shipping.update');
                    Route::get('delete/{id}',[App\Http\Controllers\procurement_officer\ShippingController::class, 'delete'])->name('procurement_officer.orders.shipping.delete');
                    Route::get('details/{id}',[App\Http\Controllers\procurement_officer\ShippingController::class, 'details'])->name('procurement_officer.orders.shipping.details');
                    Route::post('create_shipping_award',[App\Http\Controllers\procurement_officer\ShippingController::class, 'create_shipping_award'])->name('procurement_officer.orders.shipping.create_shipping_award');
                    Route::get('shipping_award_status_disable/{id}',[App\Http\Controllers\procurement_officer\ShippingController::class, 'shipping_award_status_disable'])->name('procurement_officer.orders.shipping.shipping_award_status_disable');
                    Route::get('edit_shipping_award/{id}',[App\Http\Controllers\procurement_officer\ShippingController::class, 'edit_shipping_award'])->name('procurement_officer.orders.shipping.edit_shipping_award');
                    Route::post('update_shipping_award',[App\Http\Controllers\procurement_officer\ShippingController::class, 'update_shipping_award'])->name('procurement_officer.orders.shipping.update_shipping_award');
                });
                Route::group(['prefix'=>'calender'],function(){
                    Route::get('index/{order_id}',[App\Http\Controllers\procurement_officer\CalenderController::class, 'index'])->name('procurement_officer.orders.calender.index');
                    Route::get('getEvents/{order_id}',[App\Http\Controllers\procurement_officer\CalenderController::class, 'getEvents'])->name('procurement_officer.orders.calender.getEvents');
                    Route::post('create',[App\Http\Controllers\procurement_officer\CalenderController::class, 'create'])->name('procurement_officer.orders.calender.create');
                });
                Route::group(['prefix'=>'notes'],function(){
                    Route::get('index/{order_id}',[App\Http\Controllers\procurement_officer\OrderNotesController::class, 'index'])->name('procurement_officer.orders.notes.index');
                    Route::post('create_order_notes', [App\Http\Controllers\procurement_officer\OrderNotesController::class, 'create_order_notes'])->name('procurement_officer.orders.notes.create_order_notes');
                    Route::get('edit_order_notes/{order_id}', [App\Http\Controllers\procurement_officer\OrderNotesController::class, 'edit_order_notes'])->name('procurement_officer.orders.notes.edit_order_notes');
                    Route::post('update_order_notes/{id}', [App\Http\Controllers\procurement_officer\OrderNotesController::class, 'update_order_notes'])->name('procurement_officer.orders.notes.update_order_notes');
                    Route::get('delete_order_notes/{order_id}', [App\Http\Controllers\procurement_officer\OrderNotesController::class, 'delete_order_notes'])->name('procurement_officer.orders.notes.delete_order_notes');
                    Route::post('edit_anchor_note', [App\Http\Controllers\procurement_officer\AnchorController::class, 'edit_anchor_note'])->name('procurement_officer.orders.notes.edit_note');
                    Route::post('edit_price_offer_note', [App\Http\Controllers\procurement_officer\PriceOfferController::class, 'edit_price_offer_note'])->name('procurement_officer.orders.notes.edit_price_offer_note');
                    Route::post('edit_cash_payment_note', [App\Http\Controllers\procurement_officer\FinancialFileController::class, 'edit_cash_payment_note'])->name('procurement_officer.orders.notes.edit_cash_payment_note');
                    Route::post('edit_letter_bank_note', [App\Http\Controllers\procurement_officer\FinancialFileController::class, 'edit_letter_bank_note'])->name('procurement_officer.orders.notes.edit_letter_bank_note');
                    Route::post('edit_shipping_note', [App\Http\Controllers\procurement_officer\ShippingController::class, 'edit_shipping_note'])->name('procurement_officer.orders.notes.edit_shipping_note');
                    Route::post('edit_letter_bank_modification_note', [App\Http\Controllers\procurement_officer\FinancialFileController::class, 'edit_letter_bank_modification_note'])->name('procurement_officer.orders.notes.edit_letter_bank_modification_note');
                    Route::post('edit_insurance_note', [App\Http\Controllers\procurement_officer\OrderInsuranceController::class, 'edit_insurance_note'])->name('procurement_officer.orders.notes.edit_insurance_note');
                    Route::post('edit_clearance_note', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'edit_clearance_note'])->name('procurement_officer.orders.notes.edit_clearance_note');
                    Route::post('edit_delivery_note', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'edit_delivery_note'])->name('procurement_officer.orders.notes.edit_delivery_note');
                    Route::post('edit_order_notes_note', [App\Http\Controllers\procurement_officer\OrderNotesController::class, 'edit_order_notes_note'])->name('procurement_officer.orders.notes.edit_order_notes_note');
                    Route::get('delete_note_from_order/{id}/{modal_name}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'delete_note_from_order'])->name('procurement_officer.orders.notes.delete_note_from_order');
                });
                Route::group(['prefix'=>'attachment'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\OrderAttachmentController::class, 'index'])->name('procurement_officer.orders.attachment.index');
                    Route::post('create_order_attachment', [App\Http\Controllers\procurement_officer\OrderAttachmentController::class, 'create_order_attachment'])->name('procurement_officer.orders.attachment.create_order_attachment');
                    Route::get('edit_order_attachment/{id}', [App\Http\Controllers\procurement_officer\OrderAttachmentController::class, 'edit_order_attachment'])->name('procurement_officer.orders.attachment.edit_order_attachment');
                    Route::get('delete_order_attachment/{id}', [App\Http\Controllers\procurement_officer\OrderAttachmentController::class, 'delete_order_attachment'])->name('procurement_officer.orders.attachment.delete_order_attachment');
                });
                Route::group(['prefix'=>'price_offer_items'],function(){
                    Route::post('create', [App\Http\Controllers\procurement_officer\PriceOfferItemsController::class, 'create'])->name('procurement_officer.orders.price_offer_items.create');
                    Route::post('add_or_update_bonus', [App\Http\Controllers\procurement_officer\PriceOfferItemsController::class, 'add_or_update_bonus'])->name('procurement_officer.orders.price_offer_items.add_or_update_bonus');
                    Route::post('add_or_update_discount', [App\Http\Controllers\procurement_officer\PriceOfferItemsController::class, 'add_or_update_discount'])->name('procurement_officer.orders.price_offer_items.add_or_update_discount');
                });
                Route::group(['prefix'=>'insurance'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\OrderInsuranceController::class, 'index'])->name('procurement_officer.orders.insurance.index');
                    Route::post('create', [App\Http\Controllers\procurement_officer\OrderInsuranceController::class, 'create'])->name('procurement_officer.orders.insurance.create');
                    Route::get('edit/{id}', [App\Http\Controllers\procurement_officer\OrderInsuranceController::class, 'edit'])->name('procurement_officer.orders.insurance.edit');
                    Route::post('update', [App\Http\Controllers\procurement_officer\OrderInsuranceController::class, 'update'])->name('procurement_officer.orders.insurance.update');
                    Route::get('delete/{id}', [App\Http\Controllers\procurement_officer\OrderInsuranceController::class, 'delete'])->name('procurement_officer.orders.insurance.delete');
                });
                Route::group(['prefix'=>'clearance'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'index'])->name('procurement_officer.orders.clearance.index');
                    Route::post('create', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'create'])->name('procurement_officer.orders.clearance.create');
                    Route::post('create_order_clearance_attachment', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'create_order_clearance_attachment'])->name('procurement_officer.orders.clearance.create_order_clearance_attachment');
                    Route::post('delete_order_clearance_attachment', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'delete_order_clearance_attachment'])->name('procurement_officer.orders.clearance.delete_order_clearance_attachment');
                    Route::post('update_to_null_order_clearance_attachment', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'update_to_null_order_clearance_attachment'])->name('procurement_officer.orders.clearance.update_to_null_order_clearance_attachment');
                    Route::post('clearance_status', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'clearance_status'])->name('procurement_officer.orders.clearance.clearance_status');
                    Route::post('clearance_notes', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'clearance_notes'])->name('procurement_officer.orders.clearance.clearance_notes');
                    Route::get('get_clearance_table', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'get_clearance_table'])->name('procurement_officer.orders.clearance.get_clearance_table');
                    Route::post('update', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'update'])->name('procurement_officer.orders.clearance.update');
                    Route::get('delete/{id}', [App\Http\Controllers\procurement_officer\ClearanceController::class, 'delete'])->name('procurement_officer.orders.clearance.delete');
                });
                Route::group(['prefix'=>'delivery'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'index'])->name('procurement_officer.orders.delivery.index');
                    Route::post('create', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'create'])->name('procurement_officer.orders.delivery.create');
                    Route::get('edit/{id}', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'edit'])->name('procurement_officer.orders.delivery.edit');
                    Route::post('update', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'update'])->name('procurement_officer.orders.delivery.update');
                    Route::post('get_table_order_local_delivery_items', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'get_table_order_local_delivery_items'])->name('procurement_officer.orders.delivery.get_table_order_local_delivery_items');
                    Route::post('create_order_local_delivery_items', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'create_order_local_delivery_items'])->name('procurement_officer.orders.delivery.create_order_local_delivery_items');
                    Route::post('delete_order_local_delivery_items', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'delete_order_local_delivery_items'])->name('procurement_officer.orders.delivery.delete_order_local_delivery_items');
                    Route::post('update_order_local_delivery_items', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'update_order_local_delivery_items'])->name('procurement_officer.orders.delivery.update_order_local_delivery_items');
                    Route::get('delete/{id}', [App\Http\Controllers\procurement_officer\DeliveryController::class, 'delete'])->name('procurement_officer.orders.delivery.delete');
                });

                Route::group(['prefix'=>'forms'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\FormsController::class, 'index'])->name('procurement_officer.orders.forms.index');
                    Route::post('product_supplier_pdf', [App\Http\Controllers\procurement_officer\FormsController::class, 'product_supplier_pdf'])->name('procurement_officer.orders.forms.product_supplier_pdf');
                    Route::get('order_summery/{order_id}', [App\Http\Controllers\procurement_officer\FormsController::class, 'order_summery'])->name('procurement_officer.orders.forms.order_summery');
                });
                Route::group(['prefix'=>'invoices'],function(){
                    Route::get('index/{order_id}', [App\Http\Controllers\procurement_officer\InvoiceController::class, 'index'])->name('procurement_officer.orders.invoices.index');
                    Route::post('create', [App\Http\Controllers\procurement_officer\InvoiceController::class, 'create'])->name('procurement_officer.orders.invoices.create');
                });
            });
        });

        Route::group(['prefix' => 'storekeeper'], function () {
            Route::get('/index', [App\Http\Controllers\users\StorekeeperController::class, 'index'])->name('users.storekeeper.index');
            Route::get('/add', [App\Http\Controllers\users\StorekeeperController::class, 'add'])->name('users.storekeeper.add');
            Route::post('create', [App\Http\Controllers\users\StorekeeperController::class, 'create'])->name('users.storekeeper.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\StorekeeperController::class, 'edit'])->name('users.storekeeper.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\StorekeeperController::class, 'update'])->name('users.storekeeper.update');
            Route::get('details/{id}', [App\Http\Controllers\users\StorekeeperController::class, 'details'])->name('users.storekeeper.details');
            Route::get('personal_account/{id}', [App\Http\Controllers\users\StorekeeperController::class, 'personal_account'])->name('users.storekeeper.personal_account');
            Route::group(['prefix'=>'orders'],function(){
                Route::get('index',[App\Http\Controllers\storekeeper\OrderController::class,'index'])->name('users.storekeeper.orders.index');
            });
        });

        Route::group(['prefix' => 'secretarial'], function () {
            Route::get('/index', [App\Http\Controllers\users\SecretarialController::class, 'index'])->name('users.secretarial.index');
            Route::get('/add', [App\Http\Controllers\users\SecretarialController::class, 'add'])->name('users.secretarial.add');
            Route::post('create', [App\Http\Controllers\users\SecretarialController::class, 'create'])->name('users.secretarial.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\SecretarialController::class, 'edit'])->name('users.secretarial.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\SecretarialController::class, 'update'])->name('users.secretarial.update');
            Route::get('details/{id}', [App\Http\Controllers\users\SecretarialController::class, 'details'])->name('users.secretarial.details');
        });

        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/index', [App\Http\Controllers\users\SupplierController::class, 'index'])->name('users.supplier.index');
            Route::post('/supplier_table', [App\Http\Controllers\users\SupplierController::class, 'supplier_table'])->name('users.supplier.supplier_table');
            Route::get('/add', [App\Http\Controllers\users\SupplierController::class, 'add'])->name('users.supplier.add');
            Route::post('create', [App\Http\Controllers\users\SupplierController::class, 'create'])->name('users.supplier.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\SupplierController::class, 'edit'])->name('users.supplier.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\SupplierController::class, 'update'])->name('users.supplier.update');
            Route::get('details/{id}', [App\Http\Controllers\users\SupplierController::class, 'details'])->name('users.supplier.details');
            Route::post('createProductSupplier', [App\Http\Controllers\users\SupplierController::class, 'createProductSupplier'])->name('users.supplier.createProductSupplier');
            Route::get('delete_product_supplier/{id}', [App\Http\Controllers\users\SupplierController::class, 'delete_product_supplier'])->name('users.supplier.delete_product_supplier');
            Route::post('create_for_supplier', [App\Http\Controllers\UsersFollowUpRecordsController::class, 'create_for_supplier'])->name('users.supplier.create_for_supplier');
            Route::get('delete_for_supplier/{id}', [App\Http\Controllers\UsersFollowUpRecordsController::class, 'delete_for_supplier'])->name('users.supplier.delete_for_supplier');
            Route::post('update_follow_by', [App\Http\Controllers\users\SupplierController::class, 'update_follow_by'])->name('users.supplier.update_follow_by');
            Route::post('product_search_ajax', [App\Http\Controllers\users\SupplierController::class, 'product_search_ajax'])->name('users.supplier.product_search_ajax');
            Route::post('product_list_ajax', [App\Http\Controllers\users\SupplierController::class, 'product_list_ajax'])->name('users.supplier.product_list_ajax');
            Route::post('add_to_product_supplier_ajax', [App\Http\Controllers\users\SupplierController::class, 'add_to_product_supplier_ajax'])->name('users.supplier.add_to_product_supplier_ajax');
            Route::group(['prefix' => 'company_contact_person'], function () {
                Route::get('edit/{id}', [App\Http\Controllers\users\SupplierController::class, 'contact_person_edit'])->name('users.supplier.contact_person_edit');
                Route::post('update', [App\Http\Controllers\users\SupplierController::class, 'contact_person_update'])->name('users.supplier.contact_person_update');
            });
            Route::group(['prefix' => 'bank_supplier'], function () {
                Route::post('create_bank_supplier', [App\Http\Controllers\users\SupplierController::class, 'create_bank_supplier'])->name('users.supplier.create_bank_supplier');
                Route::get('edit_bank_supplier/{id}', [App\Http\Controllers\users\SupplierController::class, 'edit_bank_supplier'])->name('users.supplier.edit_bank_supplier');
                Route::post('update_bank_supplier', [App\Http\Controllers\users\SupplierController::class, 'update_bank_supplier'])->name('users.supplier.update_bank_supplier');
                Route::get('delete_bank_supplier/{id}', [App\Http\Controllers\users\SupplierController::class, 'delete_bank_supplier'])->name('users.supplier.delete_bank_supplier');
            });
        });

        Route::group(['prefix' => 'delivery_company'], function () {
            Route::get('/index', [App\Http\Controllers\users\DeliveryCompanyController::class, 'index'])->name('users.delivery_company.index');
            Route::get('/add', [App\Http\Controllers\users\DeliveryCompanyController::class, 'add'])->name('users.delivery_company.add');
            Route::post('create', [App\Http\Controllers\users\DeliveryCompanyController::class, 'create'])->name('users.delivery_company.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\DeliveryCompanyController::class, 'edit'])->name('users.delivery_company.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\DeliveryCompanyController::class, 'update'])->name('users.delivery_company.update');
            Route::get('details/{id}', [App\Http\Controllers\users\DeliveryCompanyController::class, 'details'])->name('users.delivery_company.details');
        });

        Route::group(['prefix' => 'clearance_companies'], function () {
            Route::get('/index', [App\Http\Controllers\users\ClearanceCompaniesController::class, 'index'])->name('users.clearance_companies.index');
            Route::get('/add', [App\Http\Controllers\users\ClearanceCompaniesController::class, 'add'])->name('users.clearance_companies.add');
            Route::post('create', [App\Http\Controllers\users\ClearanceCompaniesController::class, 'create'])->name('users.clearance_companies.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\ClearanceCompaniesController::class, 'edit'])->name('users.clearance_companies.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\ClearanceCompaniesController::class, 'update'])->name('users.clearance_companies.update');
            Route::get('details/{id}', [App\Http\Controllers\users\ClearanceCompaniesController::class, 'details'])->name('users.clearance_companies.details');
        });

        Route::group(['prefix' => 'local_carriers'], function () {
            Route::get('/index', [App\Http\Controllers\users\LocalCarriersController::class, 'index'])->name('users.local_carriers.index');
            Route::get('/add', [App\Http\Controllers\users\LocalCarriersController::class, 'add'])->name('users.local_carriers.add');
            Route::post('create', [App\Http\Controllers\users\LocalCarriersController::class, 'create'])->name('users.local_carriers.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\LocalCarriersController::class, 'edit'])->name('users.local_carriers.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\LocalCarriersController::class, 'update'])->name('users.local_carriers.update');
            Route::get('details/{id}', [App\Http\Controllers\users\LocalCarriersController::class, 'details'])->name('users.local_carriers.details');
            Route::post('create_delivery_estimation_cost', [App\Http\Controllers\users\LocalCarriersController::class, 'create_delivery_estimation_cost'])->name('users.local_carriers.create_delivery_estimation_cost');
            Route::get('edit_delivery/{id}', [App\Http\Controllers\users\LocalCarriersController::class, 'edit_delivery'])->name('users.local_carriers.edit_delivery');
            Route::post('update_delivery', [App\Http\Controllers\users\LocalCarriersController::class, 'update_delivery'])->name('users.local_carriers.update_delivery');
            Route::get('delete_delivery/{id}', [App\Http\Controllers\users\LocalCarriersController::class, 'delete_delivery'])->name('users.local_carriers.delete_delivery');
        });

        Route::group(['prefix' => 'insurance_companies'], function () {
            Route::get('/index', [App\Http\Controllers\users\InsuranceCompaniesController::class, 'index'])->name('users.insurance_companies.index');
            Route::get('/add', [App\Http\Controllers\users\InsuranceCompaniesController::class, 'add'])->name('users.insurance_companies.add');
            Route::post('create', [App\Http\Controllers\users\InsuranceCompaniesController::class, 'create'])->name('users.insurance_companies.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\InsuranceCompaniesController::class, 'edit'])->name('users.insurance_companies.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\InsuranceCompaniesController::class, 'update'])->name('users.insurance_companies.update');
            Route::get('details/{id}', [App\Http\Controllers\users\InsuranceCompaniesController::class, 'details'])->name('users.insurance_companies.details');
        });

        Route::group(['prefix' => 'client'], function () {
            Route::get('/index', [App\Http\Controllers\users\ClientsController::class, 'index'])->name('users.clients.index');
            Route::get('/add', [App\Http\Controllers\users\ClientsController::class, 'add'])->name('users.clients.add');
            Route::post('create', [App\Http\Controllers\users\ClientsController::class, 'create'])->name('users.clients.create');
            Route::get('edit/{id}', [App\Http\Controllers\users\ClientsController::class, 'edit'])->name('users.clients.edit');
            Route::post('update/{id}', [App\Http\Controllers\users\ClientsController::class, 'update'])->name('users.clients.update');
            Route::get('details/{id}', [App\Http\Controllers\users\ClientsController::class, 'details'])->name('users.clients.details');
        });
    });

    Route::group(['prefix' => 'company_contact_person'], function () {
        Route::post('create', [App\Http\Controllers\CompanyContactPersonController::class, 'createForSupplier'])->name('company_contact_person.supplier.create');
        Route::get('delete/{id}', [App\Http\Controllers\CompanyContactPersonController::class, 'delete'])->name('company_contact_person.supplier.delete');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('home', [App\Http\Controllers\ProductController::class, 'home'])->name('product.home');
        Route::get('index', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
        Route::get('search_table', [App\Http\Controllers\ProductController::class, 'search_table'])->name('product.search_table');
        Route::post('import', [App\Http\Controllers\ProductController::class, 'import'])->name('product.import');
        Route::get('add', [App\Http\Controllers\ProductController::class, 'add'])->name('product.add');
        Route::post('create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
        Route::get('edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
        Route::get('details/{id}', [App\Http\Controllers\ProductController::class, 'details'])->name('product.details');
        Route::post('update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
        Route::post('createForProductSupplier', [App\Http\Controllers\ProductController::class, 'createForProductSupplier'])->name('product.createForProductSupplier');
        Route::post('edit_product_ajax', [App\Http\Controllers\ProductController::class, 'edit_product_ajax'])->name('product.edit_product_ajax');
        Route::post('delete_image', [App\Http\Controllers\ProductController::class, 'delete_image'])->name('product.delete_image');
        Route::get('qrCode_product/{id}', [App\Http\Controllers\ProductController::class, 'qrCode_product'])->name('product.qrCode_product');
        Route::get('qrCode_product/{id}', [App\Http\Controllers\ProductController::class, 'qrCode_product'])->name('product.qrCode_product');
        Route::post('create_product_compatibility', [App\Http\Controllers\ProductController::class, 'create_product_compatibility'])->name('product.create_product_compatibility');
        Route::get('edit_product_compatibility/{id}', [App\Http\Controllers\ProductController::class, 'edit_product_compatibility'])->name('product.edit_product_compatibility');
        Route::post('update_product_compatibility', [App\Http\Controllers\ProductController::class, 'update_product_compatibility'])->name('product.update_product_compatibility');
        Route::post('create_assembled_product_ajax', [App\Http\Controllers\ProductController::class, 'create_assembled_product_ajax'])->name('product.create_assembled_product_ajax');
        Route::post('list_assembled_product_ajax', [App\Http\Controllers\ProductController::class, 'list_assembled_product_ajax'])->name('product.list_assembled_product_ajax');
        Route::get('edit_assembled_product/{id}', [App\Http\Controllers\ProductController::class, 'edit_assembled_product'])->name('product.edit_assembled_product');
        Route::post('update_assembled_product', [App\Http\Controllers\ProductController::class, 'update_assembled_product'])->name('product.update_assembled_product');
        Route::post('search_assembled_product_ajax', [App\Http\Controllers\ProductController::class, 'search_assembled_product_ajax'])->name('product.search_assembled_product_ajax');
        Route::post('list_assembled_product_ajax', [App\Http\Controllers\ProductController::class, 'list_assembled_product_ajax'])->name('product.list_assembled_product_ajax');
        Route::post('delete_assembled_product_ajax', [App\Http\Controllers\ProductController::class, 'delete_assembled_product_ajax'])->name('product.delete_assembled_product_ajax');
        Route::post('assembled_product_list_for_details_in_product_ajax', [App\Http\Controllers\ProductController::class, 'assembled_product_list_for_details_in_product_ajax'])->name('product.assembled_product_list_for_details_in_product_ajax');
        Route::post('assembled_product_create_for_details_in_product_ajax', [App\Http\Controllers\ProductController::class, 'assembled_product_create_for_details_in_product_ajax'])->name('product.assembled_product_create_for_details_in_product_ajax');
        Route::post('product_lines_create', [App\Http\Controllers\ProductController::class, 'product_lines_create'])->name('product.product_lines_create');
    });

    Route::group(['prefix' => 'currency'], function () {
        Route::get('index', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currency.index');
        Route::post('create', [App\Http\Controllers\CurrencyController::class, 'create'])->name('currency.create');
        Route::get('edit/{id}', [App\Http\Controllers\CurrencyController::class, 'edit'])->name('currency.edit');
        Route::post('update/{id}', [App\Http\Controllers\CurrencyController::class, 'update'])->name('currency.update');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('index', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
        Route::post('create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
        Route::get('edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    });

    Route::group(['prefix' => 'units'], function () {
        Route::get('index', [App\Http\Controllers\UnitsController::class, 'index'])->name('units.index');
        Route::post('create', [App\Http\Controllers\UnitsController::class, 'create'])->name('units.create');
        Route::get('edit/{id}', [App\Http\Controllers\UnitsController::class, 'edit'])->name('units.edit');
        Route::post('update', [App\Http\Controllers\UnitsController::class, 'update'])->name('units.update');
        Route::post('updateUnitName', [App\Http\Controllers\UnitsController::class, 'updateUnitName'])->name('units.updateUnitName');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('index', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index');
        Route::get('order_items/{order_id}', [App\Http\Controllers\OrdersController::class, 'order_items_index'])->name('orders.order_items.index');
        Route::post('create_order', [App\Http\Controllers\OrdersController::class, 'create_order'])->name('orders.create_order');
        Route::post('create_order_items', [App\Http\Controllers\OrdersController::class, 'create_order_items'])->name('orders.create_order_items');
        Route::post('updateQtyForOrder_items', [App\Http\Controllers\OrdersController::class, 'updateQtyForOrder_items'])->name('orders.updateQtyForOrder_items');
        Route::post('updateUnitOrder_items', [App\Http\Controllers\OrdersController::class, 'updateUnitOrder_items'])->name('orders.updateUnitOrder_items');
        Route::post('selectedUnit', [App\Http\Controllers\OrdersController::class, 'selectedUnit'])->name('orders.selectedUnit');
        Route::post('updateOrderStatus/{order_id}', [App\Http\Controllers\OrdersController::class, 'updateOrderStatus'])->name('orders.updateOrderStatus');
        Route::get('/deleteItems/{order_item_id}', [App\Http\Controllers\users\ProcurmentOfficerController::class, 'deleteItems'])->name('orders.deleteItems');
    });

    Route::group(['prefix' => 'tasks'], function () {
        Route::get('index', [App\Http\Controllers\TasksController::class, 'index'])->name('tasks.index');
        Route::post('create', [App\Http\Controllers\TasksController::class, 'create'])->name('tasks.create');
        Route::get('edit/{id}', [App\Http\Controllers\TasksController::class, 'edit'])->name('tasks.edit');
        Route::post('update', [App\Http\Controllers\TasksController::class, 'update'])->name('tasks.update');
    });

    Route::group(['prefix' => 'tasks_type'], function () {
        Route::get('index', [App\Http\Controllers\TaskTypeController::class, 'index'])->name('tasks_type.index');
        Route::post('create', [App\Http\Controllers\TaskTypeController::class, 'create'])->name('tasks_type.create');
        Route::get('edit/{id}', [App\Http\Controllers\TaskTypeController::class, 'edit'])->name('tasks_type.edit');
        Route::post('update', [App\Http\Controllers\TaskTypeController::class, 'update'])->name('tasks_type.update');
    });

    Route::group(['prefix'=>'calender'],function(){
        Route::get('index',[App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
        Route::get('getEvents',[App\Http\Controllers\CalendarController::class, 'getEvents'])->name('calendar.getEvents');
        Route::post('create',[App\Http\Controllers\CalendarController::class, 'create'])->name('calendar.create');
        Route::post('updateEventDrop',[App\Http\Controllers\CalendarController::class, 'updateEventDrop'])->name('calendar.updateEventDrop');
        Route::post('update',[App\Http\Controllers\CalendarController::class, 'update'])->name('calendar.update');
    });

    Route::group(['prefix'=>'bank'],function(){
        Route::get('index',[App\Http\Controllers\BankController::class, 'index'])->name('bank.index');
        Route::post('create',[App\Http\Controllers\BankController::class, 'create'])->name('bank.create');
        Route::get('edit/{id}',[App\Http\Controllers\BankController::class, 'edit'])->name('bank.edit');
        Route::post('update/{id}',[App\Http\Controllers\BankController::class, 'update'])->name('bank.update');
    });

    Route::group(['prefix'=>'shipping_methods'],function(){
        Route::get('index',[App\Http\Controllers\ShippingMethodController::class, 'index'])->name('shipping_methods.index');
        Route::post('create',[App\Http\Controllers\ShippingMethodController::class, 'create'])->name('shipping_methods.create');
        Route::get('edit/{id}',[App\Http\Controllers\ShippingMethodController::class, 'edit'])->name('shipping_methods.edit');
        Route::post('update/{id}',[App\Http\Controllers\ShippingMethodController::class, 'update'])->name('shipping_methods.update');
    });

    Route::group(['prefix'=>'clearance_attachment'],function(){
        Route::get('index',[App\Http\Controllers\ClearanceAttachmentController::class, 'index'])->name('clearance_attachment.index');
        Route::post('create',[App\Http\Controllers\ClearanceAttachmentController::class, 'create'])->name('clearance_attachment.create');
        Route::get('edit/{id}',[App\Http\Controllers\ClearanceAttachmentController::class, 'edit'])->name('clearance_attachment.edit');
        Route::post('update',[App\Http\Controllers\ClearanceAttachmentController::class, 'update'])->name('clearance_attachment.update');
    });

    Route::group(['prefix'=>'estimation_cost_element'],function(){
        Route::get('index',[App\Http\Controllers\EstimationCostElementController::class, 'index'])->name('estimation_cost_element.index');
        Route::post('create',[App\Http\Controllers\EstimationCostElementController::class, 'create'])->name('estimation_cost_element.create');
        Route::get('edit/{id}',[App\Http\Controllers\EstimationCostElementController::class, 'edit'])->name('estimation_cost_element.edit');
        Route::post('update',[App\Http\Controllers\EstimationCostElementController::class, 'update'])->name('estimation_cost_element.update');
    });

    Route::group(['prefix'=>'trash'],function(){
        Route::get('index',[App\Http\Controllers\TrashController::class, 'index'])->name('trash.index');
        Route::get('updateOrderStatus/{id}',[App\Http\Controllers\TrashController::class, 'updateOrderStatus'])->name('trash.updateOrderStatus');
    });

    Route::group(['prefix'=>'order_status'],function(){
        Route::get('index',[App\Http\Controllers\OrderStatusController::class, 'index'])->name('order_status.index');
        Route::post('create',[App\Http\Controllers\OrderStatusController::class, 'create'])->name('order_status.create');
        Route::get('edit/{id}',[App\Http\Controllers\OrderStatusController::class, 'edit'])->name('order_status.edit');
        Route::post('update',[App\Http\Controllers\OrderStatusController::class, 'update'])->name('order_status.update');
    });

    Route::group(['prefix'=>'reports'],function(){
        Route::get('index',[App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::group(['prefix'=>'suppliers'],function (){
            Route::get('suppliers_report',[App\Http\Controllers\ReportController::class, 'suppliers_report'])->name('reports.suppliers.suppliers_report');
            Route::post('supplier_report',[App\Http\Controllers\ReportController::class, 'supplier_report'])->name('reports.suppliers.supplier_report');
            Route::post('details_supplier_report',[App\Http\Controllers\ReportController::class, 'details_supplier_report'])->name('reports.suppliers.details_supplier_report');
        });
        Route::group(['prefix'=>'products'],function (){
            Route::get('products_report',[App\Http\Controllers\ReportController::class, 'products_report'])->name('reports.products.products_report');
            Route::post('products_to_the_company_report',[App\Http\Controllers\ReportController::class, 'products_to_the_company_report'])->name('reports.products.products_to_the_company_report');
        });
        Route::group(['prefix'=>'orders'],function (){
            Route::get('order_index',[App\Http\Controllers\ReportController::class, 'order_index'])->name('reports.orders.order_index');
            Route::post('order_table',[App\Http\Controllers\ReportController::class, 'order_table'])->name('reports.orders.order_table');
        });
        Route::group(['prefix'=>'financial_report'],function (){
            Route::get('index',[App\Http\Controllers\ReportController::class, 'financial_report_index'])->name('reports.financial_report.financial_report_index');
            Route::post('financial_report_PDF',[App\Http\Controllers\ReportController::class, 'financial_report_PDF'])->name('reports.financial_report.financial_report_PDF');
            Route::post('financial_report_data_filter_ajax',[App\Http\Controllers\ReportController::class, 'financial_report_data_filter_ajax'])->name('reports.financial_report.financial_report_data_filter_ajax');
        });
    });

    Route::group(['prefix'=>'setting'],function(){
        Route::get('index',[App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
        Route::group(['prefix'=>'system_setting'],function(){
            Route::get('index',[App\Http\Controllers\SystemSettingController::class, 'index'])->name('setting.system_setting.index');
            Route::post('create',[App\Http\Controllers\SystemSettingController::class, 'create'])->name('setting.system_setting.create');
        });
        Route::group(['prefix'=>'user_category'],function(){
            Route::get('index',[App\Http\Controllers\UserCategoryController::class, 'index'])->name('setting.user_category.index');
            Route::post('create',[App\Http\Controllers\UserCategoryController::class, 'create'])->name('setting.user_category.create');
            Route::get('edit/{id}',[App\Http\Controllers\UserCategoryController::class, 'edit'])->name('setting.user_category.edit');
            Route::post('update',[App\Http\Controllers\UserCategoryController::class, 'update'])->name('setting.user_category.update');
        });
        Route::group(['prefix'=>'machine'],function(){
            Route::get('index',[App\Http\Controllers\MachineController::class, 'setting_index'])->name('setting.machine.setting_index');
            Route::post('create',[App\Http\Controllers\MachineController::class, 'create'])->name('setting.machine.create');
            Route::get('edit/{id}',[App\Http\Controllers\MachineController::class, 'edit'])->name('setting.machine.edit');
            Route::post('update',[App\Http\Controllers\MachineController::class, 'update'])->name('setting.machine.update');
            Route::get('delete/{id}',[App\Http\Controllers\MachineController::class, 'delete'])->name('setting.machine.delete');
        });
    });

    Route::get('generate', function () {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        echo 'ok';
    });

});

// Accounting System //
Route::group(['prefix'=>'accounting','middleware'=>'auth'],function(){
    Route::group(['prefix'=>'taxes'],function(){
        Route::get('index',[App\Http\Controllers\accounting\TaxesController::class , 'index'])->name('accounting.texes.index');
        Route::post('create',[App\Http\Controllers\accounting\TaxesController::class , 'create'])->name('accounting.texes.create');
        Route::get('edit/{id}',[App\Http\Controllers\accounting\TaxesController::class , 'edit'])->name('accounting.texes.edit');
        Route::post('update',[App\Http\Controllers\accounting\TaxesController::class , 'update'])->name('accounting.texes.update');
        Route::get('delete/{id}',[App\Http\Controllers\accounting\TaxesController::class , 'delete'])->name('accounting.texes.delete');
    });
    Route::group(['prefix'=>'purchase_invoices'],function(){
        Route::get('index',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'index'])->name('accounting.purchase_invoices.index');
        Route::get('new_invoices_index',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'new_invoices_index'])->name('accounting.purchase_invoices.new_invoices_index');
        Route::post('create_new_invoices',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'create_new_invoices'])->name('accounting.purchase_invoices.create_new_invoices');
        Route::get('edit_invoices/{id}',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'edit_invoices'])->name('accounting.purchase_invoices.edit_invoices');
        Route::post('update_invoices',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'update_invoices'])->name('accounting.purchase_invoices.update_invoices');
        Route::get('delete_invoices/{id}',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'delete_invoices'])->name('accounting.purchase_invoices.delete_invoices');
        Route::post('create_purchase_invoices_from_order',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'create_purchase_invoices_from_order'])->name('accounting.purchase_invoices.create_purchase_invoices_from_order');
        Route::post('update_purchase_invoices_from_ajax',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'update_purchase_invoices_from_ajax'])->name('accounting.purchase_invoices.update_purchase_invoices_from_ajax');
        Route::post('search_order_ajax',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'search_order_ajax'])->name('accounting.purchase_invoices.search_order_ajax');
        Route::post('invoice_table_index_ajax',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'invoice_table_index_ajax'])->name('accounting.purchase_invoices.invoice_table_index_ajax');
        Route::group(['prefix'=>'invoices'],function(){
            Route::get('view/{id}',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'invoice_view'])->name('accounting.purchase_invoices.invoice_view');
            Route::post('search_product_ajax',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'search_product_ajax'])->name('accounting.purchase_invoices.search_product_ajax');
            Route::post('invoice_table',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'invoice_table'])->name('accounting.purchase_invoices.invoice_table');
            Route::post('create_product_ajax',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'create_product_ajax'])->name('accounting.purchase_invoices.create_product_ajax');
            Route::post('edit_inputs_from_invoice',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'edit_inputs_from_invoice'])->name('accounting.purchase_invoices.edit_inputs_from_invoice');
            Route::post('delete_item',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'delete_item'])->name('accounting.purchase_invoices.delete_item');
            Route::post('update_invoice_reference_number_ajax',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'update_invoice_reference_number_ajax'])->name('accounting.purchase_invoices.update_invoice_reference_number_ajax');
            Route::post('update_tax_id_ratio',[App\Http\Controllers\accounting\PurchaseInvoicesController::class , 'update_tax_id_ratio'])->name('accounting.purchase_invoices.update_tax_id_ratio');
        });
    });

    Route::group(['prefix'=>'sales_invoices'],function(){
        Route::get('index',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'index'])->name('accounting.sales_invoices.index');
        Route::post('invoice_table_index_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'invoice_table_index_ajax'])->name('accounting.sales_invoices.invoice_table_index_ajax');
        Route::get('new_invoices_index',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'new_invoices_index'])->name('accounting.sales_invoices.new_invoices_index');
        Route::post('create_new_invoices',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'create_new_invoices'])->name('accounting.sales_invoices.create_new_invoices');
        Route::get('edit_invoices/{id}',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'edit_invoices'])->name('accounting.sales_invoices.edit_invoices');
        Route::post('update_invoices',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'update_invoices'])->name('accounting.sales_invoices.update_invoices');
        Route::get('delete_invoices/{id}',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'delete_invoices'])->name('accounting.sales_invoices.delete_invoices');
        Route::post('create_purchase_invoices_from_order',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'create_purchase_invoices_from_order'])->name('accounting.sales_invoices.create_purchase_invoices_from_order');
        Route::post('update_purchase_invoices_from_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'update_purchase_invoices_from_ajax'])->name('accounting.sales_invoices.update_purchase_invoices_from_ajax');
        Route::post('search_order_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'search_order_ajax'])->name('accounting.sales_invoices.search_order_ajax');
        Route::post('invoice_table_index_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'invoice_table_index_ajax'])->name('accounting.sales_invoices.invoice_table_index_ajax');
        Route::group(['prefix'=>'invoices'],function(){
            Route::get('view/{id}',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'invoice_view'])->name('accounting.sales_invoices.invoice_view');
            Route::post('search_product_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'search_product_ajax'])->name('accounting.sales_invoices.search_product_ajax');
            Route::post('invoice_table',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'invoice_table'])->name('accounting.sales_invoices.invoice_table');
            Route::post('create_product_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'create_product_ajax'])->name('accounting.sales_invoices.create_product_ajax');
            Route::post('edit_inputs_from_invoice',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'edit_inputs_from_invoice'])->name('accounting.sales_invoices.edit_inputs_from_invoice');
            Route::post('delete_item',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'delete_item'])->name('accounting.sales_invoices.delete_item');
            Route::post('update_invoice_reference_number_ajax',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'update_invoice_reference_number_ajax'])->name('accounting.sales_invoices.update_invoice_reference_number_ajax');
            Route::post('update_tax_id_ratio',[App\Http\Controllers\accounting\SalesInvoicesController::class , 'update_tax_id_ratio'])->name('accounting.sales_invoices.update_tax_id_ratio');
        });
    });
});

Route::group(['prefix'=>'production'],function (){
    Route::get('index',[App\Http\Controllers\production\ProducationLineController::class,'index'])->name('production.index');
    Route::post('create',[App\Http\Controllers\production\ProducationLineController::class,'create'])->name('production.create');
    Route::get('edit/{id}',[App\Http\Controllers\production\ProducationLineController::class,'edit'])->name('production.edit');
    Route::post('update',[App\Http\Controllers\production\ProducationLineController::class,'update'])->name('production.update');
    Route::post('get_product_name_for_add_production_name_ajax',[App\Http\Controllers\production\ProducationLineController::class,'get_product_name_for_add_production_name_ajax'])->name('production.get_product_name_for_add_production_name_ajax');
    Route::post('create_production_line_ajax',[App\Http\Controllers\production\ProducationLineController::class,'create_production_line_ajax'])->name('production.create_production_line_ajax');
    Route::post('production_line_input_table',[App\Http\Controllers\production\ProducationLineController::class,'production_line_input_table'])->name('production.production_line_input_table');
    Route::post('create_production_input_ajax',[App\Http\Controllers\production\ProducationLineController::class,'create_production_input_ajax'])->name('production.create_production_input_ajax');
    Route::post('cost_of_production_output_table_ajax',[App\Http\Controllers\production\ProducationLineController::class,'cost_of_production_output_table_ajax'])->name('production.cost_of_production_output_table_ajax');
    Route::post('update_estimated_cost_ajax',[App\Http\Controllers\production\ProducationLineController::class,'update_estimated_cost_ajax'])->name('production.update_estimated_cost_ajax');
    Route::post('update_height_for_product_ajax',[App\Http\Controllers\production\ProducationLineController::class,'update_height_for_product_ajax'])->name('production.update_height_for_product_ajax');
    Route::group(['prefix'=>'production_inputs'],function (){
        Route::get('index/{id}',[App\Http\Controllers\production\ProducationLineController::class,'production_input'])->name('production.production_inputs.index');
        Route::post('create',[App\Http\Controllers\production\ProducationLineController::class,'production_input_create'])->name('production.production_inputs.create');
        Route::get('delete/{id}',[App\Http\Controllers\production\ProducationLineController::class,'production_input_delete'])->name('production.production_inputs.production_input_delete');
        Route::post('upload_image',[App\Http\Controllers\production\ProducationLineController::class,'upload_attachment'])->name('production.production_inputs.upload_attachment');
        Route::post('create_production_orders',[App\Http\Controllers\production\ProducationLineController::class,'create_production_orders'])->name('production.production_inputs.create_production_orders');
        Route::get('edit_production_orders/{id}',[App\Http\Controllers\production\ProducationLineController::class,'edit_production_orders'])->name('production.production_inputs.edit_production_orders');
        Route::post('update_production_orders',[App\Http\Controllers\production\ProducationLineController::class,'update_production_orders'])->name('production.production_inputs.update_production_orders');
        Route::get('delete_production_orders/{id}',[App\Http\Controllers\production\ProducationLineController::class,'delete_production_orders'])->name('production.production_inputs.delete_production_orders');
        Route::post('upload_image',[App\Http\Controllers\production\ProducationLineController::class,'upload_image'])->name('production.production_inputs.upload_image');
        Route::post('list_image',[App\Http\Controllers\production\ProducationLineController::class,'list_image'])->name('production.production_inputs.list_image');
        Route::post('delete_image',[App\Http\Controllers\production\ProducationLineController::class,'delete_image'])->name('production.production_inputs.delete_image');
        Route::post('update_product_and_qty_for_production_lines_ajax',[App\Http\Controllers\production\ProducationLineController::class,'update_product_and_qty_for_production_lines_ajax'])->name('production.production_inputs.update_product_and_qty_for_production_lines_ajax');
        Route::post('update_production_order_status',[App\Http\Controllers\production\ProducationLineController::class,'update_production_order_status'])->name('production.production_inputs.update_production_order_status');
        Route::post('production_order_table_ajax',[App\Http\Controllers\production\ProducationLineController::class,'production_order_table_ajax'])->name('production.production_inputs.production_order_table_ajax');
        Route::post('update_product_line_inputs_ajax',[App\Http\Controllers\production\ProducationLineController::class,'update_product_line_inputs_ajax'])->name('production.production_inputs.update_product_line_inputs_ajax');
        Route::post('production_input_table_ajax',[App\Http\Controllers\production\ProducationLineController::class,'production_input_table_ajax'])->name('production.production_inputs.production_input_table_ajax');
        Route::post('delete_production_input_ajax',[App\Http\Controllers\production\ProducationLineController::class,'delete_production_input_ajax'])->name('production.production_inputs.delete_production_input_ajax');
        Route::post('summery_production_inputs_table_ajax',[App\Http\Controllers\production\ProducationLineController::class,'summery_production_inputs_table_ajax'])->name('production.production_inputs.summery_production_inputs_table_ajax');
        Route::post('the_length_of_the_output_item_ajax',[App\Http\Controllers\production\ProducationLineController::class,'the_length_of_the_output_item_ajax'])->name('production.production_inputs.the_length_of_the_output_item_ajax');
        Route::post('production_lines_table_ajax',[App\Http\Controllers\production\ProducationLineController::class,'production_lines_table_ajax'])->name('production.production_inputs.production_lines_table_ajax');
        Route::group(['prefix'=>'settings'],function (){
            Route::post('production_setting_list',[App\Http\Controllers\production\SettingController::class , 'production_setting_list'])->name('production.production_inputs.settings.production_setting_list');
            Route::post('create',[App\Http\Controllers\production\SettingController::class , 'create'])->name('production.production_inputs.settings.create');
            Route::get('edit/{id}',[App\Http\Controllers\production\SettingController::class , 'edit'])->name('production.production_inputs.settings.edit');
            Route::post('update',[App\Http\Controllers\production\SettingController::class , 'update'])->name('production.production_inputs.settings.update');
            Route::get('delete/{id}',[App\Http\Controllers\production\SettingController::class , 'delete'])->name('production.production_inputs.settings.delete');
        });
    });
    Route::group(['prefix'=>'production_orders'],function (){
        Route::get('index',[App\Http\Controllers\production\ProductionOrderController::class,'index'])->name('production.production_orders.index');
    });
});

Route::group(['prefix'=>'price_offer_sales'],function (){
    Route::get('index',[App\Http\Controllers\sales\PriceOfferSalesController::class,'index'])->name('price_offer_sales.index');
    Route::post('create',[App\Http\Controllers\sales\PriceOfferSalesController::class,'create'])->name('price_offer_sales.create');
    Route::get('edit/{id}',[App\Http\Controllers\sales\PriceOfferSalesController::class,'edit'])->name('price_offer_sales.edit');
    Route::post('update',[App\Http\Controllers\sales\PriceOfferSalesController::class,'update'])->name('price_offer_sales.update');
    Route::post('price_offer_sales_table_ajax',[App\Http\Controllers\sales\PriceOfferSalesController::class,'price_offer_sales_table_ajax'])->name('price_offer_sales.price_offer_sales_table_ajax');
    Route::group(['prefix'=>'price_offer_sales_items'],function (){
        Route::get('price_offer_sales_items_index/{id}',[App\Http\Controllers\sales\PriceOfferSalesController::class,'price_offer_sales_items_index'])->name('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index');
        Route::post('price_offer_sales_items_table_ajax',[App\Http\Controllers\sales\PriceOfferSalesController::class,'price_offer_sales_items_table_ajax'])->name('price_offer_sales.price_offer_sales_items.price_offer_sales_items_table_ajax');
        Route::post('product_list_search',[App\Http\Controllers\sales\PriceOfferSalesController::class,'product_list_search'])->name('price_offer_sales.price_offer_sales_items.product_list_search');
        Route::post('create_price_offer_sales_items_ajax',[App\Http\Controllers\sales\PriceOfferSalesController::class,'create_price_offer_sales_items_ajax'])->name('price_offer_sales.price_offer_sales_items.create_price_offer_sales_items_ajax');
        Route::post('delete_price_offer_sales_items',[App\Http\Controllers\sales\PriceOfferSalesController::class,'delete_price_offer_sales_items'])->name('price_offer_sales.price_offer_sales_items.delete_price_offer_sales_items');
        Route::post('update_qty_price_price_offer_sales_items_ajax',[App\Http\Controllers\sales\PriceOfferSalesController::class,'update_qty_price_price_offer_sales_items_ajax'])->name('price_offer_sales.price_offer_sales_items.update_qty_price_price_offer_sales_items_ajax');
        Route::post('price_offer_sales_items_pdf',[App\Http\Controllers\sales\PriceOfferSalesController::class,'price_offer_sales_items_pdf'])->name('price_offer_sales.price_offer_sales_items.price_offer_sales_items_pdf');
        Route::post('update_currency_notes_customer_for_price_offer_sales_items_ajax',[App\Http\Controllers\sales\PriceOfferSalesController::class,'update_currency_notes_customer_for_price_offer_sales_items_ajax'])->name('price_offer_sales.price_offer_sales_items.update_currency_notes_customer_for_price_offer_sales_items_ajax');
        Route::post('get_sum_price_offer_sales_items_ajax',[App\Http\Controllers\sales\PriceOfferSalesController::class,'get_sum_price_offer_sales_items_ajax'])->name('price_offer_sales.price_offer_sales_items.get_sum_price_offer_sales_items_ajax');
    });
});

