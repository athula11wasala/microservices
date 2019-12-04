<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use App\Dtech\Helper;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Config;
use App\Traits\CategoryValidator;
use App\Traits\ApiResponser;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Request as res;

class CategoryController extends Controller
{
    use CategoryValidator;
    use ApiResponser;
    private $categoryService;

    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    /**
     * create category
     * @param  [string] name
     * @return [string] message
     */
    public function createCategory(Request $request)
    {

        $validator = $validator = $this->categoryValidate($request->all());
        if($validator->fails()){

            return response()->json($this->unProcessRequest(
                $this->customErrorMsg($validator->messages())));
        }
          try {
              $this->data = $this->categoryService->createCategory($request->all());
              $this->message =  \config('messages.category_added');
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

    /**
     * @param Request $request
     */
    public function editCategory(Request $request){

        $validator = $validator = $this->categoryValidate($request->all(),'Put');
        if($validator->fails()){

            return response()->json($this->unProcessRequest(
                $this->customErrorMsg($validator->messages())));
        }
        try {
            $this->data = $this->categoryService->editCategory($request->all());
            $this->message =  \config('messages.category_updated');
            return response()->json($this->responseData());
        }
        catch(\PDOException $ex){

            return response()->json($this->pdoException($ex->getMessage()));
        }
        catch (\Exception $ex){

            return response()->json($this->unProcessRequest( $ex->getMessage(),$ex->getCode()));
        }
    }

    /**
     * @param Request $request
     */
    public function deleteCategory($id=null){

        $validator = $validator = $this->categoryValidate(['id'=>$id],'Delete');
        if($validator->fails()){

            return response()->json($this->unProcessRequest(
                $this->customErrorMsg($validator->messages())));
        }
        try {
            $this->data = $this->categoryService->deleteCategory($id);
            $this->message =  \config('messages.category_deleted');
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

    /**
     * create category
     * @param  [string] name
     * @return [string] message
     */
    public function showCategory(Request $request)
    {

        try {
            $this->data = $this->categoryService->getCategoryInfo($request->all());
            $this->message =  \config('messages.category_added');
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
