<?php


namespace App\Dtech;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

/**
 * Helper Class for Equio
 * @package App\Equio
 */
class Helper
{

    public static function arrayUnset($request, $keys)
    {
        foreach ( $keys as $value ) {
            if ( array_key_exists ( $value, $request ) ) {
                unset( $request[ $value ] );
            }
        }
        return $request;
    }



}
