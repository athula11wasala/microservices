<?php


namespace App\Dtech;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

/**
 * Helper Class for Equio
 * @package App\Equio
 */
class Helper
{
    public static function customErrorMsg($errorMsg)
    {

        $objErrors = (array)$errorMsg;
        $errorArr = $objErrors[ key ( $objErrors ) ];
        $validateArr = [];
        $validateMessge = [];
        if ( !empty( $errorArr ) ) {
            foreach ( $errorArr as $rows ) {
                $validateArr[] = $rows;
            }
            if ( !empty( $validateArr ) ) {
                foreach ( $validateArr as $row ) {
                    $validateMessge[] = $row[ 0 ];
                }
            }
        }
        return $validateMessge;
    }

    public static function arrayUnset($request, $keys)
    {
        foreach ( $keys as $value ) {
            if ( array_key_exists ( $value, $request ) ) {
                unset( $request[ $value ] );
            }
        }
        return $request;
    }

    public static function loggedUser () {

        $objUser = Auth::user();
        $data['user_id'] = $objUser->id;
        $data['email'] = $objUser->email;
        return $data;
    }

}
