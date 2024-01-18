<?php


namespace logic;
use Exception;

/**
 * Class StatusException
 * @package logic
 */
class StatusException extends Exception
{
    public function __toString()
    {
        $msg = $this->getMessage();
        $error = "Unknown status: ".$msg;
        error_log($error);
    }
}