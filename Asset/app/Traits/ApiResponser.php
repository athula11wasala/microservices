<?php
namespace App\Traits;

trait ApiResponser
{
    private $error = '';
    private $code = '200';
    private $message = '';
    private $data = '';

    public  function responseData(){

        if(($this->data)) {

            $data['error'] = $this->error;
            $data['code'] = $this->code;
            $data['message'] = $this->message;
            if (!is_bool($this->data)) {
                $data['data'] = $this->data;
            }

            return $data;
        }
        return $this->unProcessRequest();
    }

    public  function unProcessRequest($error = '',$code= ''){


        $data['error'] = !empty($error)? $error : \config('messages.un_processable_request');
        $data['code'] =  !empty($code)? $code : 400;
        $data['message'] = '';

        return $data;
    }

    public  function pdoException($error= ''){

        $data['error'] = !empty($error )? $error: '';
        $data['code'] =  500;
        $data['message'] = '';

        return $data;
    }

    public function customErrorMsg($errorMsg)
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
       // $this->error = $validateMessge;
        //$this->code = 400;
    }

}