<?php

namespace Ruslanovich\DateConverter\Services;

use Ruslanovich\DateConverter\Enums\RowTypeEnum;
use Ruslanovich\DateConverter\Models\DateIntervalModel;
use Ruslanovich\DateConverter\Models\DateModel;
use Ruslanovich\DateConverter\Models\DateCollection;

interface RowToModelConverterInterface
{
    /**
     * @param string $row
     * @return RowTypeEnum
     */
    public function getRowType(string $row): RowTypeEnum;

    /**
     * @param string $row
     * @return DateModel
     */
    public function convertToDate(string $row): DateModel;

    /**
     * @param string $row
     * @return DateCollection
     */
    public function convertToDateCollection(string $row): DateCollection;

    /**
     * @param string $row
     * @return DateIntervalModel
     */
    public function convertToInterval(string $row): DateIntervalModel;
}