<?php


namespace Transave\ScolaCvManagement\Actions\Auth;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Transave\ScolaCvManagement\Helpers\ResponseHelper;
use Transave\ScolaCvManagement\Helpers\ValidationHelper;

class ResetPassword
{
    use ResponseHelper, ValidationHelper;
    private $user, $request, $validatedInput, $passwordReset;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        try {
            return $this
                ->validateRequest()
                ->setUser()
                ->setPassword()
                ->deletePasswordReset();
        }catch (\Exception $e) {
            return $this->sendServerError($e);
        }
    }

    private function deletePasswordReset()
    {
        $this->passwordReset = DB::table('password_resets')->where("token", $this->validatedInput['token'])->delete();
        return $this->sendSuccess(null, "password reset successful");
    }

    private function setUser()
    {
        $this->passwordReset = DB::table('password_resets')->where("token", $this->validatedInput['token'])->first();
        $this->user = config('scolacv.auth_model')::query()->where("email", $this->passwordReset->email)->first();

        if (empty($this->user)) {
            return $this->sendError("No user with the token supplied", [], 404);
        }

        if (Carbon::now()->gt(Carbon::parse($this->passwordReset->created_at)->addHours(1))) {
            return $this->sendError("Token expired", [], 403);
        }
        return $this;
    }

    private function setPassword()
    {
        $this->user->password = bcrypt($this->validatedInput["password"]);
        $this->user->save();
        return $this;
    }

    private function validateRequest()
    {
        $this->validatedInput = $this->validate($this->request, [
            "token" => 'required|digits_between:100000,999999',
            "password" => 'string|min:6',
        ]);
        return $this;
    }

}