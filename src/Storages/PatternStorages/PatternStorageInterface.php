<?php

namespace Ruslanovich\DateConverter\Storages\PatternStorages;

use Ruslanovich\DateConverter\Enums\MonthNumberEnum;
use Ruslanovich\DateConverter\Models\PatternCollection;

interface PatternStorageInterface
{
    /**
     * @return PatternCollection
     */
    public function getPatternCollection(): PatternCollection;

    /**
     * @param string $monthName
     * @return MonthNumberEnum|null
     */
    public function getMonthNumber(string $monthName): ?MonthNumberEnum;

    /**
     * @return array
     */
    public function getCollectionSeparators(): array;

    /**
     * @return array
     */
    public function getIntervalSeparators(): array;

    /**
     * @return array
     */
    public function getIntervalInitialWords(): array;
}