<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class InvalidMultipleStorageException extends Exception
{
    public static function create(): InvalidMultipleStorageException
    {
        return new self(
            message: 'Creating multiple storage is invalid',
            code: Errors::INVALID_MULTIPLE_STORAGE
        );
    }
}