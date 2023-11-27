<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NextOfKin;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class NextOfKinController extends Controller
{
    use ResponseHelper;


    public function index()
    {
        $fetch = NextOfKin::with('user')->get();
        return $this->sendSuccess($fetch, 'List of All Next Of Kins and Benefactors');
    }



    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'first_name'=>'required|string|max:225',
            'last_name'=>'required|string|max:225',
            'relationship'=>'required|string|max:225',
            'address'=>'required|string|max:225',
            'user_id'=>'required|string|max:225|exists:users,id',
            'phone_number'=>'required|string|max:225|unique:next_of_kins,phone_number',
            'email'=>'string|email|max:225|unique:next_of_kins,email',
        ],[
            'first_name.required' => 'first name is required',
            'last_name.required' => 'last name is required',
            'relationship.required' => 'relationship is required',
            'address.required' => 'address is required',
            'user_id.required'=> 'user Id is required',
            'phone_number.unique'=> 'phone number already in use, please try a different phone number',
            'email.unique'=> 'email already in use, please try a different email',
        ]);
        
        if($validatedData->fails()){
        return $this->sendError($validatedData->errors(), [], 400);
        }

        $this->fetch = NextOfKin::query()->create($request->all());
        return $this->sendSuccess($this->fetch, 'Next of Kin created successfully', 200);
    }



    public function update(Request $request, $nextOfKinId)
    {
        $validatedData = Validator::make($request->all(), [
            'first_name'=>'string|max:225',
            'last_name'=>'string|max:225',
            'relationship'=>'string|max:225',
            'address'=>'string|max:225',
            'user_id'=>'string|max:225|exists:users,id',
            'phone_number'=>'string|max:225|unique:next_of_kins,phone_number'.$nextOfKinId,
            'email'=>'string|email|max:225|unique:next_of_kins,email'.$nextOfKinId,
        ],[
            'phone_number.unique'=> 'phone number already in use, please try a different phone number',
            'email.unique'=> 'email already in use, please try a different email',
        ]);

        $this->update = NextOfKin::find($nextOfKinId);
        $this->update->update($request->all());
        return $this->sendSuccess($this->update, 'Next of Kin Data updated successfully', 200);
    }


    public function show($nextOfKinId)
    {
        $this->details = NextOfKin::query()->find($nextOfKinId);
        return sendSuccess($this->details, 'Next of Kin Details', 200);
    }

    public function delete($nextOfKinId)
    {
        $this->delete = NextOfKin::query()->find($nextOfKinId)->delete();
        return $this->sendSuccess('Next of Kin deleted successfully', 200);
    }

}
