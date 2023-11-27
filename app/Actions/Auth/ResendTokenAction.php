<?php


namespace Transave\ScolaCvManagement\Actions\Auth;


use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Transave\ScolaCvManagement\Helpers\ResponseHelper;
use Transave\ScolaCvManagement\Helpers\ValidationHelper;
use Transave\ScolaCvManagement\Http\Notifications\WelcomeNotification;

class ResendTokenAction
{
    use ResponseHelper, ValidationHelper;
    private $request, $validatedInput, $user, $token;

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
                ->setToken()
                ->saveToken()
                ->sendNotification()
                ->sendSuccess(null, 'token resend successfully');
        }catch (\Exception $exception) {
            return $this->sendServerError($exception);
        }
    }

    private function setToken()
    {
        $this->token = rand(100000, 999999);
        return $this;
    }

    private function setUser()
    {
        $this->user = config('scolacv.auth_model')::query()->find($this->validatedInput['user_id']);
        return $this;
    }

    private function saveToken()
    {
        if ($this->user->is_verified) {
            return $this->sendSuccess(null, 'user already verified');
        }
        $this->user->update([
            "token" => $this->token,
            "email_verified_at" => Carbon::now()
        ]);
        return $this;
    }

    private function sendNotification()
    {
        try {
            Notification::route('mail', $this->user->email)
                ->notify(new WelcomeNotification([
                    "token" => $this->token,
                    "user" => $this->user
                ]));
        } catch (\Exception $exception) {
        }
        return $this;
    }

    private function validateRequest()
    {
        $this->validatedInput = $this->validate($this->request, [
            "user_id" => 'required|exists:users,id'
        ]);
        return $this;
    }
}