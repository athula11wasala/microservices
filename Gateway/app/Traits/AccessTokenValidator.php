<?php
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
trait AccessTokenValidator
{
    protected function rule($method, $data) {
        switch ($method) {
            case 'Get':
            case 'Signup': {
                return [
                    'email' => ['required','unique:users'],
                    'password' => 'required|confirmed',
                    'password_confirmation'=>'required'
                ];
            }
            case 'login': {
                return [
                    'email' => ['required'],
                    'password' => 'required',

                ];
            }
            default:
                break;
        }
    }
    protected function accessTokenValidate(array $data, $method = "Post") {
        $messages = [
            'email.required' => 'Please add Email',
            'password.required' => 'Please add Password',
        ];

        $validator = Validator::make($data, $this->rule($method, $data), $messages);
        return $validator;
    }
}
