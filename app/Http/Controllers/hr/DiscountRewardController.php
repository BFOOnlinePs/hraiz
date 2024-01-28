<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\DiscountReward;
use Illuminate\Http\Request;

class DiscountRewardController extends Controller
{
    public function create_reward(Request $request)
    {
        $discounts_rewards = new DiscountReward();
        $discounts_rewards->value = $request->value_rewardCreate;
        $discounts_rewards->currency_id = $request->currency_id_rewardCreate;
        if ($request->hasFile('attached_file_rewardCreate')) {
            $file = $request->file('attached_file_rewardCreate');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'reward_file' . $extension;
            $file->storeAs('discounts_rewards_attachment', $filename, 'public');
            $discounts_rewards->attached_file = $filename;
        }
        $discounts_rewards->notes = $request->notes_rewardCreate;
        $discounts_rewards->inserted_by = auth()->user()->id;
        $discounts_rewards->user_id = $request->employee_id;
        $discounts_rewards->type = 1;
        if($discounts_rewards->save()) {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['success'=>'تم إضافة مكافأة للموظف بنجاح']);

        }
        else {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['fail'=>'لم تتم إضافة المكافأة ، هناك خلل ما']);
        }
    }
    public function edit_reward(Request $request)
    {
        $discounts_rewards = DiscountReward::find($request->id_rewardEdit);
        $discounts_rewards->value = $request->value_rewardEdit;
        $discounts_rewards->currency_id = $request->currency_id_rewardEdit;
        if ($request->hasFile('attached_file_rewardEdit')) {
            $file = $request->file('attached_file_rewardEdit');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'reward_file' . $extension;
            $file->storeAs('discounts_rewards_attachment', $filename, 'public');
            $discounts_rewards->attached_file = $filename;
        }
        $discounts_rewards->notes = $request->notes_rewardEdit;
        if($discounts_rewards->save()) {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['success'=>'تم تعديل المكافأة للموظف بنجاح']);

        }
        else {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['fail'=>'لم تتم تعديل المكافأة ، هناك خلل ما']);
        }
    }
    public function create_discount(Request $request)
    {
        $discounts_rewards = new DiscountReward();
        $discounts_rewards->value = $request->value_discountCreate;
        $discounts_rewards->currency_id = $request->currency_id_discountCreate;
        if ($request->hasFile('attached_file_discountCreate')) {
            $file = $request->file('attached_file_discountCreate');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'discount_file' . $extension;
            $file->storeAs('discounts_rewards_attachment', $filename, 'public');
            $discounts_rewards->attached_file = $filename;
        }
        $discounts_rewards->notes = $request->notes_discountCreate;
        $discounts_rewards->inserted_by = auth()->user()->id;
        $discounts_rewards->user_id = $request->employee_id;
        $discounts_rewards->type = 0;
        if($discounts_rewards->save()) {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['success'=>'تم إضافة حسم للموظف بنجاح']);
        }
        else {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['fail'=>'لم تتم إضافة الحسم ، هناك خلل ما']);
        }
    }
    public function edit_discount(Request $request)
    {
        $discounts_rewards = DiscountReward::find($request->id_discountEdit);
        $discounts_rewards->value = $request->value_discountEdit;
        $discounts_rewards->currency_id = $request->currency_id_discountEdit;
        if ($request->hasFile('attached_file_discountEdit')) {
            $file = $request->file('attached_file_discountEdit');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'discount_file' . $extension;
            $file->storeAs('discounts_rewards_attachment', $filename, 'public');
            $discounts_rewards->attached_file = $filename;
        }
        $discounts_rewards->notes = $request->notes_discountEdit;
        if($discounts_rewards->save()) {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['success'=>'تم تعديل الحسم للموظف بنجاح']);

        }
        else {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['fail'=>'لم يتم تعديل الحسم ، هناك خلل ما']);
        }
    }
    public function create_advance(Request $request)
    {
        $discounts_rewards = new DiscountReward();
        $discounts_rewards->value = $request->value_advanceCreate;
        $discounts_rewards->currency_id = $request->currency_id_advanceCreate;
        if ($request->hasFile('attached_file_advanceCreate')) {
            $file = $request->file('attached_file_advanceCreate');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'advance_file' . $extension;
            $file->storeAs('discounts_rewards_attachment', $filename, 'public');
            $discounts_rewards->attached_file = $filename;
        }
        $discounts_rewards->notes = $request->notes_advanceCreate;
        $discounts_rewards->inserted_by = auth()->user()->id;
        $discounts_rewards->user_id = $request->employee_id;
        $discounts_rewards->type = 2;
        if($discounts_rewards->save()) {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['success'=>'تم إضافة سُلفة للموظف بنجاح']);
        }
        else {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['fail'=>'لم تتم إضافة السُلفة ، هناك خلل ما']);
        }
    }
    public function edit_advance(Request $request)
    {
        $discounts_rewards = DiscountReward::find($request->id_advanceEdit);
        $discounts_rewards->value = $request->value_advanceEdit;
        $discounts_rewards->currency_id = $request->currency_id_advanceEdit;
        if ($request->hasFile('attached_file_advanceEdit')) {
            $file = $request->file('attached_file_advanceEdit');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'advance_file' . $extension;
            $file->storeAs('discounts_rewards_attachment', $filename, 'public');
            $discounts_rewards->attached_file = $filename;
        }
        $discounts_rewards->notes = $request->notes_advanceEdit;
        if($discounts_rewards->save()) {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['success'=>'تم تعديل السُلفة للموظف بنجاح']);

        }
        else {
            return redirect()->route('hr.employees.details' , ['id' => $request->employee_id,'tab_id'=>5])->with(['fail'=>'لم يتم تعديل السُلفة ، هناك خلل ما']);
        }
    }
}
