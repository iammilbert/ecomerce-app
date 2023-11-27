<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    use ResponseHelper;

    public function index()
    {
        $country = Country::with('state')->get();

        return $this->sendSuccess($country, 'List of registered countries');
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=>'required|string|max:225|unique:countries,name',
            'code'=>'required|string|max:6|unique:countries,code',
        ],[
        'name.unique' => 'The Country name has already been taken. Please choose a different one.',
        'code.unique'=> 'The Country code already exist, confirm the code',
        'code.required'=>'Country code is required',
        'name.required'=> 'The country name is required',
        ]);
        
        if($validatedData->fails()){
        return $this->sendError($validatedData->errors(), [], 400);
        }

        $country = Country::query()->create($request->all());
        return $this->sendSuccess($country, 'country created successfully', 200);
    }


    public function update(Request $request, $countryId)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=>'string|max:225|unique:countries,name'.$countryId,
            'code'=>'string|max:6|unique:countries,code'.$countryId,
        ],[
        'name.unique' => 'The Country name has already been taken. Please choose a different one.',
        'code.unique'=> 'The Country code already exist, confirm the code',
            ]);

    if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
        }

        $this->update = Country::find($countryId);
        $this->update->update($request->all());
        return $this->sendSuccess($this->update, 'country updated successfully', 200);
    }


    public function show($countryId)
    {
        $this->details = Country::with(['state'])->find($countryId);
        return $this->sendSuccess($this->details, 'Country information', 200);
    }

    public function delete($countryId)
    {
       $data = Country::query()->find($countryId)->delete();
        return $this->sendSuccess('Country deleted successfully', 200);
    }

}
