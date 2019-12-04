<?php

namespace App\Http\Controllers;

use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use  App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Services\AsssetService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use App\Dtech\DtechException;

class AssetController extends BaseController
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     private $assetService;

    public  function __construct(AsssetService $asssetService)
    {
        $this->assetService = $asssetService;
    }

    public  function show(Request $request)
    {
        try {
            $data =  ($this->assetService->showCategory($request->all()));
            return response()->json (
                $this->assetService->showCategory($data,$data['code']));
        }
        catch(\Exception $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
        catch(DtechException $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
    }

     public  function createCategory(Request $request){

        try {
            $data = $this->assetService->createCategory($request->all());
            return response()->json($data,$data['code']?? 400);
                                    
        }
        catch(\Exception $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
        catch(DtechException $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }

    }

    public  function editCategory(Request $request){

        try {
            $data = $this->assetService->editCategory($request->all());
            return response()->json($data,$data['code']?? 400);

        }
        catch(\Exception $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
        catch(DtechException $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
    }

    public function deleteCategory($id=null){


        try {
            $data = $this->assetService->deletetCategory($id);
            return response()->json($data,$data['code']?? 400);

        }
        catch(\Exception $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
        catch(DtechException $ex){
            return $this->errorResponse(
                $ex->getMessage(),$ex->getCode());
        }
    }

}
