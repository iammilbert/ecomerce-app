<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralMessage;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class GeneralMessageController extends Controller
{
     use ResponseHelper;

    public function index()
    {
        $sms = GeneralMessage::all();
          return $this->sendSuccess($sms, 'Public messages', 200);
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'phone_number'=> 'string|max:225',
            'message'=>'required|string|max:225',
            'subject'=> 'required|string|max:255',
            'name'=>'required|string|max:225',
            'email'=>'string|max:225',
         ] );

    if($validatedData->fails()){
     return $this->sendError($validatedData->errors(), [], 400);
    }

    $this->$sms = GeneralMessage::query()->create($request->all());
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

        $this->update = GeneralMessage::find($messageId);
        $this->update->update($request->all());
        return $this->sendSuccess($this->update, 'Status updated', 200);
    }


    public function show($messageId)
    {
        $this->details = GeneralMessage::query()->find($messageId);
        return sendSuccess($this->details, 'Message Details', 200);
    }


    public function delete($messageId)
    {
        $this->delete = GeneralMessage::query()->find($messageId)->delete();
        return $this->sendSuccess( $this->delete, 'Message deleted', 200);
    }
}
