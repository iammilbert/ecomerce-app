<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    use ResponseHelper;


    public function index()
        {
            $this->all = Category::with('product')->get();;
            return $this->sendSuccess($this->all, 'List of Category', 200);
        }


    public function register(Request $request)
        {
                $validatedData = Validator::make($request->all(), [
                    'category_name'=> 'required|string|max:225|unique:categories,category_name',
                ],[
                    'category_name.required' => 'Category name is required',
                    'category_name.unique'=>'Category already exists, please choose a different category name',
                ]);

            if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
            }

            $category = Category::query()->create($request->all());
            return $this->sendSuccess($category, 'Category Created successfully', 200);
        }



    public function update(Request $request, $categoryId)
        {
            $validatedData = Validator::make($request->all(), [
                    'category_name'=>'max:225|unique:categories,category_name,'. $categoryId,
                ],[
                    'category_name.unique'=>'Category already exists, please choose a different category', 
                ]);

            if($validatedData->fails()){
                return $this->sendError($validatedData->errors(), [], 400);
                }

                $category = Category::findOrFail($categoryId);
                $category->update($request->all());
                 return $this->sendSuccess($category, 'Category updated', 200);
        }



         public function show($categoryId)
            {
                $this->details = Category::query()->find($categoryId);
                return $this->sendSuccess($this->details, 'Category information', 200);
            }


        public function delete($categoryId)
            {
                $this->delete = Category::query()->find($categoryId)->delete();
                return $this->sendSuccess( $this->delete, 'Category deleted successfully', 200);
            }


}
