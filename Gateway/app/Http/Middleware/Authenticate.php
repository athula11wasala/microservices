<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Auth as SysAuth;
use Illuminate\Support\Facades\DB;
use App\Models\OauthAccessToken as OauthToken;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }
           $userToken = OauthToken::select('token')
                        ->where(['email' => SysAuth::user()->email])
                          ->first('token');
        if(!empty($userToken)){

            $headerToken = preg_replace('/\s+/', '',
                          str_replace("Bearer","",$request->header('Authorization')));

            $userToken = preg_replace('/\s+/', '', $userToken->token);
            if($headerToken !=  $userToken){
                return response('Unauthorized.', 401);
            }
        }

        return $next($request);
    }
}
