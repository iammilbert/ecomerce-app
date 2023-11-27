<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    use ResponseHelper;


    public function index()
    {
        $discount = Discount::all();
       return $this->sendSuccess($discount, 'List of Discounts', 200);
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'percentage'=>'required|string|max:225',
            'validity_start'=>'required|string|max:225',
            'validity_end'=>'required|string|max:225',
            'usage_limit'=>'required|string|max:225',
            'code'=>'required|string|max:225|unique:discounts,code',
        ],[
            'percentage.required' => 'Percentage is required',
            'validity_start.required'=> 'Validity Start Date is required',
            'validity_end.required'=> 'Validity End Date is required',
            'usage_limit.required'=> 'usage Limit is required',
            'code.required'=> 'Discount Code is required',
            'code.unique'=> 'Code already in use, please try a different code',

            ]);

         if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
            }

        $input = Discount::query()->create($request->all());
         return $this->sendSuccess($input, 'Discount Created Successfully', 200);

    }



    public function update(Request $request, $discountId)
    {
        $validatedData = Validator::make($request->all(), [
            'percentage'=>'string|max:225',
            'validity_start'=>'string|max:225',
            'validity_end'=>'string|max:225',
            'usage_limit'=>'string|max:225',
            'code' => 'string|max:225|unique:discounts,code,' .$discountId,
        ],[
            'code.unique'=> 'Code already in use, please try a different code',

            ]);
    
     if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
        }

        $find = Discount::find($discountId);
  
        $find->update($request->all());
        return $this->sendSuccess($find, 'Discount updated successfully', 200);
    }


    public function show($discountId)
        {
            $this->details = Discount::query()->find($discountId);
            return sendSuccess($this->details, 'Dicount Details', 200);
        }


    public function activate_discount(Request $request)
    {
    $validatedData = Validator::make($request->all(), [
            'product_id'=>'string|max:225|exists:products,id',
            'discount_id'=>'string|max:225|exists:discounts,id',
        ]);

        if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
        }

        $data = $request->all();
        $save = ProductDiscount::create($data);
        
        return $this->sendSuccess($save, 'Discount Added', 200);
    }


 public function update_active_discount(Request $request, $productId)
    {
    $validatedData = Validator::make($request->all(), [
            'discount_id'=>'string|max:225|exists:discounts,id',
        ]);

        if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
        }

        $data = ProductDiscount::find($productId);
        $input = $request->all();
        $data->update($input);
        
        return $this->sendSuccess($save, 'Updated successfully', 200);
    }



    public function delete($discountId)
        {
            $this->delete = Discount::query()->find($discountId)->delete();
            return $this->sendSuccess('Discount deleted successfully', 200);
        }

}
