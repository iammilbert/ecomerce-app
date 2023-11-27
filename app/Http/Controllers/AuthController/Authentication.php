<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\ForgotPassword;


class Authentication extends Controller
{
    use ResponseHelper;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout']);
    }



   public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return $this->sendSuccess($validator->errors(), 400); 
        } 
    
        $credentials = $request->only('email', 'password');
        $success = User::where('email', $credentials['email'])->first();
        
        if($success)
        {
            if(Hash::check($credentials['password'], $success->password)){
                
                $success['token'] =  $success->createToken('MyAuthApp')->plainTextToken;

                return $this->sendSuccess($success, 'User login successfully', 200);
            } 
        
            return $this->sendSuccess('Password Incorrect, try again', 201); 
        }
        return $this->sendSuccess('This Email is not registered', 201); 
    }



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }



    public function updateEmail(Request $request, $userId)
    {
    $validatedInput = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$userId,
        ],[
            'email.email'=> 'Incorrect email format entered',
            'email.unique'=> 'email address already taken, try a different one.'
        ]);

        if($validatedInput->fails())
        {
            return $this->sendError($validatedInput->errors(), 400);
        }

         $this->user = User::query()->find($userId);
        
         $this->user->update([
            'email' => $request->email
        ]);
        return $this->sendSuccess($this->user->refresh(), 'Email updated successfully');

    }



    public function changePassword(Request $request, $userId)
    {
    $validatedInput = Validator::make($request->all(), [
            'new_password' => 'required|string|min:4|max:6',
            'old_password' => 'required|string',
        ],[
            'new_password.required'=> 'New Password is required.',
            'new_password.min'=> 'The new Password must be minimum of 4 characters',
            'new_password.max'=> 'The new Password must be maximum of 6 characters',
            'new_password.max'=> 'The new Password must be maximum of 6 characters',
            'old_password.required'=> 'Old Password is required.'
        ]);

        if($validatedInput->fails())
        {
            return $this->sendError($validatedInput->errors(), 400);
        }

         $this->user = User::query()->find($userId);

     if (Hash::check($request->old_password, $this->user->password)) {
            $this->user->password = bcrypt($request->new_password);
            $this->user->save();
            return $this->sendSuccess($this->user->refresh(), 'Password changed successfully');
        }
        return $this->sendError('Password entered did not match existing one', [], 403);

    }



    /**
     * Forgot password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\App\Helpers\Response
     */
    public function forgotPassword(Request $request)
    {
        return (new ForgotPassword($request->all()))->execute();
    }
    


}




