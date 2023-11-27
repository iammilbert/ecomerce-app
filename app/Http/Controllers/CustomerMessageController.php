<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerMessage;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class CustomerMessageController extends Controller
{
     use ResponseHelper;

    public function index()
    {
        $sms = CustomerMessage::with('user')->get();
          return $this->sendSuccess($sms, 'Customers messages', 200);
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'user_id'=> 'required|string|max:225|exists:users,id',
            'message'=>'required|string|max:225',
            'subject'=> 'required|string|max:255',
            'date'=>'required|string|max:225',
         ] );

    if($validatedData->fails()){
     return $this->sendError($validatedData->errors(), [], 400);
    }

    $this->sms = CustomerMessage::query()->create($request->all());
     return $this->sendSuccess($this->sms, 'Message Sent', 200);
    }



    public function update(Request $request, $messageId)
    {
        $validatedData = Validator::make($request->all(), [
            'status'=>  'max:225|required|string',
        ]);
        
      if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
            }

        $this->update = CustomerMessage::find($messageId);
        $this->update->update($request->all());
        return $this->sendSuccess($this->update, 'Status updated', 200);
    }


    public function show($userId)
    {
        $this->details = CustomerMessage::with('user')->get();
        $this->details->find($userId);
        return $this->sendSuccess($this->details, 'User Messages History', 200);
    }

        public function message_details($messageId)
    {
        $this->details = CustomerMessage::with('user')->get();
        $this->details->find($messageId);
        return $this->sendSuccess($this->details, 'Message Details', 200);
    }


    public function destroy($messageId)
    {
        $this->delete = CustomerMessage::query()->find($messageId)->delete();
        return $this->sendSuccess( $this->delete, 'Message deleted', 200);
    }
}
