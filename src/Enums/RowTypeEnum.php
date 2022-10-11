<?php

namespace Ruslanovich\DateConverter\Enums;

use Exception;

class RowTypeEnum
{
    public const SIMPLE_DATE = 1;
    public const DATE_COLLECTION = 2;
    public const DATE_INTERVAL = 3;
    public const UNDEFINED = 4;

    /**
     * @throws Exception
     */
    public static function from(int $type): RowTypeEnum
    {
        $types = [
            self::SIMPLE_DATE, self::DATE_COLLECTION, self::DATE_INTERVAL, self::UNDEFINED,
        ];

        if (!in_array($type, $types)) {
            throw new Exception('unable to create RowTypeEnum');
        }

        return new self($type);
    }

    public function __construct(private int $type)
    {
    }

    public function getType(): int
    {
        return $this->type;
    }
}