<?php

namespace App\Http\Controllers;

use App\Services\RoleUserService;
use App\Traits\RoleUserValidators;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;

class RoleUserController extends BaseController
{
    use RoleUserValidators;
    use ApiResponser;

    private $role_user;

    public function __construct(RoleUserService $roleUserService)
    {
        $this->role_user=$roleUserService;
    }

    /**
     * add permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPermissions(Request $request){

        $validator = $this->validatePermissionsAdd($request->all());

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 400);
        }

        try{
            \DB::beginTransaction();
            $this->role_user->getAddNewPermission($request);
            \DB::commit();
            return response()->json(['message' => __('messages.permission_added')], 200);

        }catch (Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => __('messages.un_processable_request')], 400);
        }
    }

    /**
     * add permission to role
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPermissionToRole(Request $request){
        $validator = $this->validatePermissionsAddToRole($request->all());

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()], 400);
        }
        try{
            \DB::beginTransaction();
            $permission=$this->role_user->getPermissionByName($request->permission_name);
            $role=$this->role_user->getRoleByName($request->role);
            if ($this->role_user->getRolePermissionExists($role->id, $permission->id)){
                \DB::rollBack();
                return response()->json(['error' => __(config('messages.role_permission_already_exists'))], 400);
            } else{
                $role->attachPermission($permission);
                \DB::commit();
                return response()->json(['message' => __(config('messages.role_permission_added'))], 200);
            }

        }catch (Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => __(config('messages.un_processable_request'))], 400);
        }
    }

    /**
     * get user role and permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRoleAndPermissions(Request $request){

        $permissions= $this->role_user->getUserRolesAndPermissions(Auth::id());
        if($permissions) {
            return response()->json($permissions, 200);
        }
        return response()->json(['Error' => __('messages.no_user_permissions')], 400);
    }

    /**
     * check authnicate user's role
     * @param $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function hasRole($role){
        if (Auth::user()->hasRole($role)){
            return response()->json(['has_role' => true], 200);
        } else{
            return response()->json(['has_role' => false], 200);
        }
    }

    /**
     * check authnicate user permission
     * @param $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function hasPermission($permission){
        if (Auth::user()->can($permission)){
            return response()->json(['has_permission' => true], 200);
        } else{
            return response()->json(['has_permission' => false], 200);
        }
    }
}
