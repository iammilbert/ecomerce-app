<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ResponseHelper;


    public function index()
    {
        $product = Product::with('category')->get();
       return $this->sendSuccess($product, 'List of Products', 200);
    }


    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'product_name'=>'required|string|max:225|unique:products',
            'description'=>'required|string|max:225',
            'price'=>'required|string|max:225',
            'quantity'=>'required|string|max:225',
            'category_id'=>'required|string|max:225|exists:categories,id',
        ],[
        'product_name.unique' => 'The product name has already been taken. Please choose a different one.',
        'description.required'=> 'Description is required',
        'price.required'=> 'Product Price is required',
        'quantity.required'=> 'Product Quantity is required',
        'category_id'=> 'Category is required',

            ]);

         if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
            }

        $input = Product::query()->create($request->all());
         return $this->sendSuccess($input, 'Register Successfully', 200);

    }



    public function update(Request $request, $productId)
    {
        $validatedData = Validator::make($request->all(), [
            'product_name'=>'sometimes|required|string|max:225|unique:products,product_name'.$productId,
            'description'=>'sometimes|required|string|max:225',
            'price'=>'sometimes|required|string|max:225',
            'quantity'=>'sometimes|required|string|max:225',
            'category_id'=>'sometimes|required|string|max:225|exists:categories,id',
        ],[
            'product_name.unique'=>'Product name already exists, choose a different product name',
        ]);
    
     if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
        }

        $update = Product::with('category')->get()->find($productId);
  
        
        if($request->category_id != null && $update->category_id != $request->category_id){
                return $this->sendError('Invalid Category suplied', [], 400);
        };

        $update->update($request->all());
        return $this->sendSuccess($update, 'Product updated successfully', 200);
    }


     public function show($productId)
    {
        $this->details = Product::query()->find($productId);
        return sendSuccess($this->details, 'Product information', 200);
    }


    public function delete($productId)
    {
        $this->delete = Product::query()->find($productId)->delete();
        return $this->sendSuccess('Product deleted successfully', 200);
    }

}
