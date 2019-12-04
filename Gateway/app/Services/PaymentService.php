<?php
namespace App\Services;

use App\Traits\ConsumesExternalService;

 class PaymentService {

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
         $this->baseUri = config('services.asset.base_uri');
         $this->secret = config('services.asset.secret');
     }

     /**
      * show the full list of user from the asset service
      * @return string
      */
     public function paymentInfo($parm)
     {
         return $this->performRequest('GET', 'api/show');
     }

     /**
      * Create payment using the asset service
      * @return string
 */
     public function createPayment($data)
     {

         return $this->performRequest('POST', 'api/category/add-category', $data);
     }


 }
