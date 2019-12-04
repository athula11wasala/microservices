<?php

namespace App\Http\Middleware;


use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\User;
use Zizaco\Entrust\Entrust;

class TestRole
{

   public function __construct(Entrust $objEntrust)
   {
       $this->obj = $objEntrust;
   }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if ( !is_array ( $roles ) ) {
            $roles = explode ( self::DELIMITER, $roles );
        }

        if ( Auth::guest () || !$request->user ()->hasRole ( $roles ) ) {
            if ( ($request->header ( 'Content-Type' ) == 'application/json') ||
                ($request->header ( 'Accept' ) == 'application/json')
            ) {
                return response ()->json ( ['Error' => __ ( 'messages.no_permission' )], 403 );
            } else {
                abort ( 403 );
            }
        }

        return $next( $request );
    }


}
