<?php

namespace Ruslanovich\DateConverter\Enums;

use Exception;

class MonthNumberEnum
{
    public const JANUARY = 1;
    public const FEBRUARY = 2;
    public const MARCH = 3;
    public const APRIL = 4;
    public const MAY = 5;
    public const JUNE = 6;
    public const JULY = 7;
    public const AUGUST = 8;
    public const SEPTEMBER = 9;
    public const OCTOBER = 10;
    public const NOVEMBER = 11;
    public const DECEMBER = 12;

    /**
     * @throws Exception
     */
    public static function from(int $monthNumber): MonthNumberEnum
    {
        $months = [
            self::JANUARY, self::FEBRUARY, self::MARCH, self::APRIL, self::MAY, self::JUNE, self::JULY,
            self::AUGUST, self::SEPTEMBER, self::OCTOBER, self::NOVEMBER, self::DECEMBER
        ];
        
        if (!in_array($monthNumber, $months)) {
            throw new Exception('unable to create MonthNumberEnum');
        }

        return new self($monthNumber);
    }

    public function __construct(private int $monthNumber)
    {
    }

    public function getMonthNumber(): int
    {
        return $this->monthNumber;
    }
}