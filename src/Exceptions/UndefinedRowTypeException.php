<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class UndefinedRowTypeException extends Exception
{
    public static function create(?string $row): UndefinedRowTypeException
    {
        return new self(
            message: 'Type of row (' . $row . ') is undefined',
            code: Errors::UNDEFINED_ROW_TYPE
        );
    }
}