<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class ConvertToDateIntervalException extends Exception
{
    public static function create(?string $row): ConvertToDateIntervalException
    {
        return new self(
            message: 'Converting row (' . $row . ') to dateInterval is impossible',
            code: Errors::INVALID_DATE_INTERVAL_CONVERT
        );
    }
}