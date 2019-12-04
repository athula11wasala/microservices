<?php

namespace App\Http\Controllers\Auth;

use App\Events\AccessTokenCreated;
use Illuminate\Http\Request;
use  App\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use App\Events\Event;
use App\Traits\AccessTokenValidator;
use App\Http\Controllers\BaseController;
use App\Traits\ApiResponser;
use App\Dtech\Helper;
use Illuminate\Http\Response as IlluminateResponse;

class AccessTokenController extends BaseController
{
    use AccessTokenValidator;
    use ApiResponser;
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $validator = $validator = $this->accessTokenValidate($request->all(), 'Signup');
        if ($validator->passes()) {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user->save();
            return $this->successResponse([
                'message' => __('messages.registration_success')
            ], IlluminateResponse::HTTP_CREATED
            );
        } else {
            return $this->errorResponse(
                Helper::customErrorMsg($validator->messages()),IlluminateResponse::HTTP_BAD_REQUEST);
        }

    }
    /**Authnicate  user.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['email', 'password']);

        if (! $token = $this->jwt->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
         \event(new AccessTokenCreated($request->input('email'),$token));

        return $this->respondWithToken($token);
    }

    /**logout user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function logout( Request $request ) {

        $token = $request->header('Authorization' );
        try {
            $this->jwt->parseToken()->invalidate( $token );

            return response()->json( [
                'error'   => false,
                'message' => ( 'logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => ( 'token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => ( 'token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => ( 'token.missing' )
            ], 500 );
        }
    }



}
