<?php

namespace App\Http\Controllers;

use App\Dtech\DtechException;
use App\Dtech\Helper;
use App\Services\SmsService;
use App\Traits\ApiResponser;
use App\Traits\SmsValidator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;

class SmsController extends BaseController
{
    use ApiResponser;
    use SmsValidator;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendSms(Request $request)
    {
        $validator = $validator = $this->smsValidate($request->all());
        if ($validator->fails()) {
            return $this->errorResponse(
                Helper::customErrorMsg($validator->messages()), 400);
        }

        try {
            $data = $this->smsService->sendSms($request->all());
            return $this->successResponse(
                [
                'message' => $data['Data']],
                 $data['Status']
              );

        } catch (Exception $ex) {
            return $this->errorResponse(
                $ex->getMessage(), $ex->getCode());
        } catch (DtechException $ex) {
            return $this->errorResponse(
                $ex->getMessage(), $ex->getCode());
        }

    }


}
