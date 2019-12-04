<?php

namespace App\Http\Controllers;

use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use  App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Services\PaymentService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use App\Dtech\DtechException;
use App\Traits\PaymentValidator;

class PaymentController extends BaseController
{
    use ApiResponser;
    use PaymentValidator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     private $paymentService;

    public  function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * create payment
     * @param  [string] name
     * @return [string] message
     */
    public function createPayment(Request $request)
    {
        $validator = $validator = $this->paymentValidate($request->all());
        if($validator->fails()){

            return response()->json($this->unProcessRequest(
                $this->customErrorMsg($validator->messages())));
        }
        try {
            $this->data = $this->paymentService->createPayment($request->all());
            $this->message =  \config('messages.payment_added');
            return response()->json($this->responseData());
        }
        catch(\PDOException $ex){

            return response()->json($this->pdoException($ex->getMessage()));
        }
        catch (\Exception $ex){

            $this->error = $ex->getMessage();
            return response()->json($this->responseData(),$ex->getCode());
        }
    }

}
