<?php

namespace Ruslanovich\DateConverter\Models;

class DateIntervalCollection
{
    /**
     * @var DateIntervalModel[]
     */
    private array $intervalModels = [];

    public function add(DateIntervalModel $intervalModel)
    {
        $this->intervalModels[] = $intervalModel;
    }

    /**
     * @return DateIntervalModel[]
     */
    public function getDateIntervals(): array
    {
        return $this->intervalModels;
    }
}