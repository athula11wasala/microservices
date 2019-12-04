<?php
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

trait SmsValidator
{
    protected function rule($method, $data) {
        switch ($method) {
            case 'Get':
            case 'Send': {
                return [
                    'mobile' => ['required'],
                    'msg' => 'required',
                ];
            }

            default:
                break;
        }
    }
    protected function smsValidate(array $data, $method = "Send") {
        $messages = [
            'mobile.required' => 'Please add Phone Number',
            'msg.required' => 'Please add Message',

        ];

        $validator = Validator::make($data, $this->rule($method, $data), $messages);
        return $validator;
    }
}
