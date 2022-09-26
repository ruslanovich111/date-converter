<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class IntervalNotFoundException extends Exception
{
    public static function create(): IntervalNotFoundException
    {
        return new self(
            message: 'Interval not found in text',
            code: Errors::UNDEFINED_ROW_TYPE
        );
    }
}