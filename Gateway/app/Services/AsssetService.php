<?php
namespace App\Services;

use App\Traits\ConsumesExternalService;

 class AsssetService {

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
     public function showCategory($parm)
     {
         return $this->performRequest('GET', 'api/category/show-category',$parm);
     }

     /**
      * Create category using the asset service
      * @return string
 */
     public function createCategory($data)
     {

         return $this->performRequest('POST', 'api/category/add-category', $data);
     }

     /**
      * Update an instance of author using the author service
      * @return string
      */
     public function editCategory($data)
     {

         return $this->performRequest('PUT', "api/category/edit-category", $data);
     }

     /**
      * delete an instance of author using the author service
      * @return string
      */
     public function deletetCategory($id)
     {
         return $this->performRequest('DELETE', "api/category/delete-category/{$id}" );
     }


     /**
      * Obtain one single category from the author service
      * @return string
      */
     public function showUser($user)
     {
         return $this->performRequest('GET', "/category/{$user}");
     }



     /**
      * Remove a single author using the author service
      * @return string
      */
     public function deleteCategory($category)
     {
         return $this->performRequest('DELETE', "/category/{$category}");
     }
 }
