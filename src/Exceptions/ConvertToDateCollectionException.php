<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class ConvertToDateCollectionException extends Exception
{
    public static function create(?string $row): ConvertToDateCollectionException
    {
        return new self(
            message: 'Converting row (' . $row . ') to dateCollection is impossible',
            code: Errors::INVALID_DATE_COLLECTION_CONVERT
        );
    }
}