<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class InvalidPatternResourceException extends Exception
{
    public static function create(): InvalidPatternResourceException
    {
        return new self(
            message: 'Invalid PatternResource syntax',
            code: Errors::INVALID_PATTERN_RESOURCE
        );
    }
}