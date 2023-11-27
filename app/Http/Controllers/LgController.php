<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lg;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class LgController extends Controller
{
    use ResponseHelper;

    public function index()
    {
        $lg = Lg::with('state')->get();
        return $this->sendSuccess($lg, 'List of registered local government');
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=>'required|string|max:225|unique:lgs,name',
            'state_id'=>'required|string|max:225|exists:states,id',
        ],[
            'name.required' => 'Local Govt. name is required',
            'state_id.required'=> 'Local Govt. State is required',
            'name.unique'=> 'Local Govt. name already in use, please try a different name'
        ]);
        
        if($validatedData->fails()){
        return $this->sendError($validatedData->errors(), [], 400);
        }

        $this->Lg = Lg::query()->create($request->all());
        return $this->sendSuccess($this->Lg, 'Local Govt. created successfully', 200);
    }


    public function update(Request $request, $lgId)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=>'string|max:225|unique:lgs,name'.$lgId,
            'state_id'=>'string|max:225|exists:states,id',
        ],[
            'name.unique'=> 'Local Govt. name already in use, please try a different name'
        ]);

        $this->update = Lg::find($lgId);
        $this->update->update($request->all());
        return $this->sendSuccess($this->update, 'Local Govt. updated successfully', 200);
    }


    public function show($lgId)
    {
        $this->details = Lg::with('state')->find($lgId);
        return $this->sendSuccess($this->details, 'Local Govt. Details', 200);
    }

    public function delete($lgId)
    {
        $this->delete = Lg::query()->find($lgId)->delete();
        return $this->sendSuccess('Local Govt. deleted successfully', 200);
    }

}
