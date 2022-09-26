<?php

namespace Ruslanovich\DateConverter\Models;

class DateIntervalModel
{
    private DateModel $initialDate;
    private DateModel $finalDate;

    /**
     * @param DateModel $initialDate
     * @param DateModel $finalDate
     */
    public function __construct(DateModel $initialDate, DateModel $finalDate)
    {
        $this->initialDate = $initialDate;
        $this->finalDate = $finalDate;
    }

    /**
     * @return DateModel
     */
    public function getInitialDate(): DateModel
    {
        return $this->initialDate;
    }

    /**
     * @return DateModel
     */
    public function getFinalDate(): DateModel
    {
        return $this->finalDate;
    }
}