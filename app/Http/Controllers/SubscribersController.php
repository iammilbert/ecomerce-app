<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class SubscribersController extends Controller
{
     use ResponseHelper;

    public function index()
    {
        $all = Subscriber::all();
          return $this->sendSuccess($all, 'List of Subscribers', 200);
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'date'=>'required|string|max:225',
            'email'=>'string|max:225|email|unique:subscribers,email',
         ] );

    if($validatedData->fails()){
     return $this->sendError($validatedData->errors(), [], 400);
    }

    $this->sms = Subscriber::query()->create($request->all());
     return $this->sendSuccess($this->sms, 'Subscribed successfully', 200);
    }


    public function delete($subscriberId)
    {
        $this->delete = Subscriber::query()->find($subscriberId)->delete();
        return $this->sendSuccess( $this->delete, 'Subscriber deleted', 200);
    }
}
