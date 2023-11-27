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

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index', 'admin']);
    }

        public function index()
        {
        $user = User::all()->where('user_type', "user");

        if ($user === null) { 
                return $this->sendSuccess('user not found', [], 200); 
                }
            return $this->sendSuccess($user, 'Registered Users', [], 200);
        }



        public function admin()
        {
        $user = User::all()->where('user_type', "admin");
            if ($user === null) { 
                return $this->sendSucces('user not found', [], 200); 
                }
            return $this->sendSuccess($user, 'Registered Admin', [], 200);
        }



    public function register(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:225',
            'last_name' => 'required|string|max:225',
            'email' => 'required|string|email|unique:users,email|max:225',
            'phone_number' => 'string|max:225|unique:users,phone_number|max:225',
            'password' => 'required|string|max:6|min:4',
            'password_confirmation' => 'required|string|max:225|same:password'
        ],[
        'email.unique' => 'The Email Provided has already been taken.',
        'email.email' => 'Incorrect Email Format entered.',
        'phone_number.unique' => 'The Phone number Provided has already been taken.',
        'email.required'=> "Email is required",
        'password_confirmation.required'=> "password confirmation is required",
        'last_name.required'=> "Last name is required",
        'first_name.required'=> "First name is required",
        'password.required'=> "password is required",
        'password_confirmation.same'=> "The two password did not match",
        ]);

        if ($validator->fails()) {
             return $this->sendError($validator->errors(), [], 400);
        } 
        
        $value = $request->all();
        $value['password'] = Hash::make($value['password']);
        $user = User::create($value);

         return $this->sendSuccess($user, 'Account created successfully. Please check your email for verification.', 200);
    
    }



    public function show($userId)
    {
        $user = User::find($userId);
        $user->where('user_type', 'user');
        return $this->sendSuccess($user, 'Customer Profile Details', 200);
    }



    public function update(Request $request, $userId)
    {
         $validatedData = Validator::make($request->all(), [
            'first_name' => 'string|max:225',
            'last_name' => 'string|max:225',
            'other_names' => 'string|max:225',
            'phone_number' => 'string|max:225|unique:users,phone_number,'.$userId,
            'gender' => 'string|max:225',
            'marital_status' => 'string|max:225',
            'dob' => 'string|max:225',
        ],[
        'phone_number.unique' => 'The Phone number Provided has already been taken.',
        ]);

        if($validatedData->fails())
            {
                return $this->sendError($validatedData->errors(), 400);
            }

        $value = User::find($userId);
        $value->update([
            'first_name' => $request->first_name,
            'last_name'=> $request->last_name,
            'other_names'=> $request->other_names,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'marital_status'=> $request->marital_status,
            'dob'=> $request->dob,
        ]);
        return $this->sendSuccess($value, 'Profile Updated', 200);
    }



public function delete($userId)
    {
        $user = User::find($userId)->delete();

         return $this->sendSuccess('Customer Deleted', [], 200);
    }


}
