<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 25/02/16
 * Time: 14:28
 */

namespace AppBundle\Exception;


use Exception;

class InvalidApiFormException extends \Exception
{
    public function __construct($message = "Some fields are wrongs,please check the API documentation", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}