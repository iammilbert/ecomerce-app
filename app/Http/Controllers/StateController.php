<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
     use ResponseHelper;

    
    public function index()
    {
        $state = State::with('country')->get();
          return $this->sendSuccess($state, 'List of Registered States with Country', 200);
    }


    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=> 'required|string|max:225|unique:states,name',
            'capital'=>'required|string|max:225|unique:states,capital',
            'country_id'=> 'required|string|max:255|exists:countries,id',
         ],[
        'name.unique' => 'The State name has already been taken. Please choose a different one.',
        'capital.unique'=> 'The state Capital already exist, Please confirm',
        'country_id.required'=> "The Country is required"
        ]);

    if($validatedData->fails()){
     return $this->sendError($validatedData->errors(), [], 400);
    }

    $this->state = State::query()->create($request->all());
     return $this->sendSuccess($this->state, 'State Created successfully', 200);
    }



    public function update(Request $request, $stateId)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|unique:states,name,'. $stateId,
            'capital'=>  'sometimes|required|string|unique:states,name,'. $stateId,
            'country_id'=> 'string|exists:countries,id',
        ],[
        'name.unique' => 'The State name has already been taken. Please choose a different one.',
        'capital.unique'=> 'The state Capital already exist, Please confirm',
        ]);
        
      if($validatedData->fails()){
            return $this->sendError($validatedData->errors(), [], 400);
            }

        $this->update = State::find($stateId);
        $this->update->update($request->all());
        return $this->sendSuccess($this->update, 'state updated successfully', 200);
    }


    public function show($stateId)
    {
        $this->details = State::with('country')->find($stateId);
        return $this->sendSuccess($this->details, 'state information', 200);
    }


    public function destroy($stateId)
    {
        $this->delete = State::query()->find($stateId)->delete();
        return $this->sendSuccess( $this->delete, 'state deleted successfully', 200);
    }
}
