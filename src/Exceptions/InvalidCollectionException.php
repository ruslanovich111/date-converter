<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class InvalidCollectionException extends Exception
{
    public static function create(?string $row): InvalidCollectionException
    {
        return new self(
            message: 'Row (' . $row . ') is not dateCollection',
            code: Errors::INVALID_COLLECTION
        );
    }
}