<?php

namespace Ruslanovich\DateConverter\Models;

use Ruslanovich\DateConverter\Enums\MonthNumberEnum;

class DateModel
{
    private ?int $day;
    private ?MonthNumberEnum $monthNumber;
    private ?int $year;

    /**
     * @param int|null $day
     * @param MonthNumberEnum|null $monthNumber
     * @param int|null $year
     */
    public function __construct(?int $day, ?MonthNumberEnum $monthNumber, ?int $year)
    {
        $this->day = $day;
        $this->monthNumber = $monthNumber;
        $this->year = $year;
    }

    /**
     * @return int|null
     */
    public function getDay(): ?int
    {
        return $this->day;
    }

    /**
     * @return MonthNumberEnum|null
     */
    public function getMonthNumber(): ?MonthNumberEnum
    {
        return $this->monthNumber;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }
}