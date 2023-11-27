<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;

class VendorController extends Controller
{
    use ResponseHelper;


    public function index()
    {  
               $companies = Vendor::with(['user', 'country_of_resident', 'lg_of_resident', 'state_of_resident'])->get(); 
                return $this->sendSuccess($companies, 'List of Vendors', 200);
    }



    public function show($userId)
    {
          $data = Vendor::find($userId);
          $data->with(['user', 'country_of_resident', 'lg_of_resident', 'state_of_resident'])->get();
          return $this->sendSuccess($data, 'Vendor Company Details', 200);
    }



    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'required|string|max:225|exists:users,id',
            'company_country_of_residence_id' => 'required|string|max:225|exists:countries,id',
            'company_lg_of_residence_id' => 'required|string|max:225|exists:lgs,id',
            'company_name' =>  'required|string|max:225|unique:vendors,company_name',
            'company_rc' => 'string|max:225|unique:vendors,company_rc',
            'company_state_of_resident_id' =>  'required|string|max:225|exists:states,id',
            'company_phone_number' =>  'string|max:225|unique:vendors,company_phone_number',
            'company_mobile_number' =>  'string|max:225|required|unique:vendors,company_mobile_number',
            'company_email' =>  'string|max:225|required|unique:vendors,company_email',
            'company_address' =>  'string|max:225|required'
        ],[
            'company_rc.unique'=> 'Company RC already exist, try a different one.',
            'company_mobile_number.unique'=> 'Mobile Number already exist, try a different one.',
            'company_phone_number.unique'=> 'Phone Number already exist, try a different one.',
            'company_name.unique'=> 'Company name provided already exist, try a different one.',
            'company_email.unique'=> 'Email already exist, try a different one.',
        ]);

        if($validatedData->fails())
            {
                return $this->sendError($validatedData->errors(), [], 400);
            }

            $data = $request->all();
            $vendors = Vendor::query()->create($data);
            return $this->sendSuccess($vendors, 'Company information Saved', 200);

    }




  public function update(Request $request, $vendorId)
     {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'string|max:225|exists:users,id',
            'company_country_of_residence_id' => 'string|max:225|exists:countries,id',
            'company_lg_of_residence_id' => 'string|max:225|exists:lgs,id',
            'company_name' =>  'string|max:225|unique:vendors,company_name,'.$vendorId,
            'company_rc' => 'string|max:225|unique:vendors,company_rc,'.$vendorId,
            'company_state_of_resident_id' =>  'string|max:225|exists:states,id',
            'company_phone_number' =>  'string|max:225|unique:vendors,company_phone_number,'.$vendorId,
            'company_mobile_number' =>  'string|max:225||unique:vendors,company_mobile_number,'.$vendorId,
            'company_email' =>  'string|max:225|email|unique:vendors,company_email,'.$vendorId,
            'company_address' =>  'string|max:225'
        ],[
            'company_rc.unique'=> 'Company RC already exist, try a different one.',
            'company_mobile_number.unique'=> 'Mobile Number already exist, try a different one.',
            'company_phone_number.unique'=> 'Phone Number already exist, try a different one.',
            'company_name.unique'=> 'Company name provided already exist, try a different one.',
            'company_email.unique'=> 'Email already exist, try a different one.',
            'company_email.email'=> 'Incorrect E-Email format.',
        ]);

        if($validatedData->fails())
            {
                return $this->sendError($validatedData->errors(), 400);
            }

        $checkData = Vendor::find($vendorId);
        if($checkData)
        {
            $checkData->update($request->all()); 
            return $this->sendSuccess($checkData, 'Company Data Updated', 200);
        }
    }



    public function delete($vendorId)
    {
               $del = Vendor::find($vendorId);
               $del->delete();
               return $this->sendSuccess('Company Deleted', [], 400);
    }
}