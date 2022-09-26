<?php

namespace Ruslanovich\DateConverter\Services;

use Ruslanovich\DateConverter\Enums\RowTypeEnum;
use Ruslanovich\DateConverter\Models\DateIntervalModel;
use Ruslanovich\DateConverter\Models\DateModel;
use Ruslanovich\DateConverter\Models\DateCollection;

interface RowToModelConverterInterface
{
    public function getRowType(string $row): RowTypeEnum;
    public function convertToDate(string $row): DateModel;
    public function convertToDateCollection(string $row): DateCollection;
    public function convertToInterval(string $row): DateIntervalModel;
}