<?php

namespace App\Dtech;

/**
 * Class EquioException
 * @package App\Equio\Exceptions
 */
class DtechException extends \Exception
{

    /**
     * DtechException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }

}
