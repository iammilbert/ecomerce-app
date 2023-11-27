<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;

class UserController extends Controller
{
    use ResponseHelper;


    public function index()
    {  
               $address = Address::with([
                              'user', 
                              'country_of_resident', 
                              'country_of_origin', 
                              'lg_of_resident', 
                              'lg_of_origin',
                              'state_of_origin',
                              'state_of_resident',
                              ])->get; 
                return $this->sendSuccess($address, 'List of all users and addresses', 200);
    }



    public function show($userId)
    {
          $data = Address::find($userId);
          $data->with([ 
               'user', 
               'country_of_resident', 
               'country_of_origin', 
               'lg_of_resident', 
               'lg_of_origin',
               'state_of_origin',
               'state_of_resident',
               ])->get;
          return $this->sendSuccess($data, 'User Address', 200);
    }


    

    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'string|max:225|exists:users,id',
            'country_of_residence_id' => 'string|max:225|exists:countries,id',
            'country_of_origin_id' =>  'string|max:225|exists:countries,id',
            'lg_of_residence_id' => 'string|max:225|exists:lgs,id',
            'lg_of_origin_id' =>  'string|max:225|exists:lgs,id',
            'state_of_origin_id' => 'string|max:225|exists:states,id',
            'state_of_resident_id' =>  'string|max:225|exists:states,id',
            'residential_address' =>  'string|max:225',
            'permanent_address' =>  'string|max:225'
        ]);

        if($validatedData->fails())
            {
                return $this->sendError($validatedData->errors(), [], 400);
            }

            $data = $request->all();
            $address = Address::query()->create($data);
            return $this->sendSuccess($address, 'Address Saved', 200);

    }




  public function update(Request $request, $addressId)
     {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'string|max:225|exists:users,id',
            'country_of_residence_id' => 'string|max:225|exists:countries,id',
            'country_of_origin_id' =>  'string|max:225|exists:countries,id',
            'lg_of_residence_id' => 'string|max:225|exists:lgs,id',
            'lg_of_origin_id' =>  'string|max:225|exists:lgs,id',
            'state_of_origin_id' => 'string|max:225|exists:states,id',
            'state_of_resident_id' =>  'string|max:225|exists:states,id',
            'residential_address' =>  'string|max:225',
            'permanent_address' =>  'string|max:225'
        ]);

        if($validatedData->fails())
            {
                return $this->sendError($validatedData->errors(), 400);
            }

        $checkData = Address::find($userId);
        if($checkData)
        {
            $checkData->update([
                'country_of_residence_id' => $request->country_of_residence_id,
                'country_of_origin_id' => $request->country_of_origin_id,
                'lg_of_residence_id' => $request->lg_of_residence_id,
                'lg_of_origin_id' => $request->lg_of_origin_id,
                'state_of_origin_id' => $request->state_of_origin_id,
                'state_of_resident_id' => $request->state_of_resident_id,
                'residential_address' => $request->residential_address,
                'permanent_address' => $request->permanent_address,
            ]); 
            return $this->sendSuccess($checkData, 'Address Updated', 200);
        }
    }



    public function delete($addressId)
    {
               $del = Address::find($userId);
               $del->delete();
               return $this->sendSuccess('Address Deleted', [], 400);
    }
}