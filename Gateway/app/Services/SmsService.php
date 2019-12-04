<?php
namespace App\Services;

use App\Traits\ConsumesExternalService;

class SmsService {

    use ConsumesExternalService;

    /**
     * The base uri to consume the asset service
     * @var string
     */
    public $baseUri;

    /**
     * The secret to consume the authors service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri =  config('services.sms.base_uri');
        $this->comId =  config('services.sms.companyId');
        $this->pword =  config('services.sms.pword');
    }

    /**
     * send sms using the sms service
     * @return string
     */
    public function sendSms($request)
    {
       $msg = $request['msg'];
       $data =  '/SendSms?phoneNumber='.$request['mobile'].
               "&smsMessage=".$msg."&companyId="
               . $this->comId."&pword=".$this->pword;
        $url = $this->baseUri;

        return $this->performSmsRequest('GET', $url,$data);
    }

}
