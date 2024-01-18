<?php


namespace src;
use Exception;

/**
 * Class ActionException
 * @package logic
 */
class ActionException extends Exception
{
    public function __toString()
    {
        $msg = $this->getMessage();
        $error = "Unknown action: ".$msg;
        error_log($error);
    }
}