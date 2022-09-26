<?php

namespace Ruslanovich\DateConverter\Services;

use Ruslanovich\DateConverter\Enums\RowTypeEnum;
use Ruslanovich\DateConverter\Exceptions\ConvertToDateCollectionException;
use Ruslanovich\DateConverter\Exceptions\ConvertToDateException;
use Ruslanovich\DateConverter\Exceptions\ConvertToDateIntervalException;
use Ruslanovich\DateConverter\Exceptions\InvalidCollectionException;
use Ruslanovich\DateConverter\Exceptions\InvalidIntervalException;
use Ruslanovich\DateConverter\Models\DateIntervalModel;
use Ruslanovich\DateConverter\Models\DateModel;
use Ruslanovich\DateConverter\Models\DateCollection;
use Ruslanovich\DateConverter\Models\PatternModel;
use Ruslanovich\DateConverter\Storages\PatternStorages\PatternStorageInterface;

class RowToModelConverter implements RowToModelConverterInterface
{
    private PatternStorageInterface $patternStorage;

    /**
     * @param PatternStorageInterface $patternStorage
     */
    public function __construct(PatternStorageInterface $patternStorage)
    {
        $this->patternStorage = $patternStorage;
    }

    /**
     * @param string $row
     * @return RowTypeEnum
     */
    public function getRowType(string $row): RowTypeEnum
    {
        $row = preg_replace('/\s+/', ' ', trim($row));

        $allDatePatterns = $this->patternStorage->getPatternCollection()->getPatternModels();
        foreach ($allDatePatterns as $datePattern) {
            if (preg_match_all('/^' . $datePattern->getPattern() . '$/ui', $row)) {
                return RowTypeEnum::SIMPLE_DATE;
            }
        }

        if ($this->getRowParts($row, $this->patternStorage->getCollectionSeparators())) {
            return RowTypeEnum::DATE_COLLECTION;
        }

        $initialWords = $this->patternStorage->getIntervalInitialWords();
        $separators = $this->patternStorage->getIntervalSeparators();
        if ($this->getIntervalParts($row, $initialWords, $separators)) {
            return RowTypeEnum::DATE_INTERVAL;
        }

        return RowTypeEnum::UNDEFINED;
    }

    /**
     * @param string $row
     * @return DateModel
     * @throws ConvertToDateException
     */
    public function convertToDate(string $row): DateModel
    {
        $row = preg_replace('/\s+/', ' ', trim($row));
        $allDatePatterns = $this->patternStorage->getPatternCollection()->getPatternModels();
        foreach ($allDatePatterns as $datePattern) {
            if (preg_match_all('/^' . $datePattern->getPattern() . '$/ui', $row)) {
                return $this->formatDateModel($row, $datePattern);
            }
        }

        throw ConvertToDateException::create($row);
    }

    private function formatDateModel(string $row, PatternModel $patternModel): DateModel
    {
        preg_match_all('/' . $patternModel->getPattern() . '/ui', $row, $matches);
        $day = $patternModel->getDayPlace() ? (int)$matches[$patternModel->getDayPlace()][0] : null;
        $year = $patternModel->getYearPlace() ? (int)$matches[$patternModel->getYearPlace()][0] : null;

        $monthName = $patternModel->getMonthPlace() ? $matches[$patternModel->getMonthPlace()][0] : null;
        $monthNumber = $this->patternStorage->getMonthNumber($monthName ?? '');

        return new DateModel($day, $monthNumber, $year);
    }

    /**
     * @param string $row
     * @return DateCollection
     * @throws ConvertToDateCollectionException
     * @throws InvalidCollectionException
     */
    public function convertToDateCollection(string $row): DateCollection
    {
        $rowParts = $this->getRowParts($row, $this->patternStorage->getCollectionSeparators());
        if (!$rowParts) {
            throw InvalidCollectionException::create($row);
        }

        $dateModelCollection = new DateCollection();
        foreach ($rowParts as $row) {
            try {
                $dateModel = $this->convertToDate($row);
                $dateModelCollection->addDateModel($dateModel);
            } catch (ConvertToDateException $exception) {
                throw ConvertToDateCollectionException::create($row);
            }
        }

        return $dateModelCollection;
    }

    /**
     * @param string $row
     * @return DateIntervalModel
     * @throws ConvertToDateIntervalException
     * @throws InvalidIntervalException
     */
    public function convertToInterval(string $row): DateIntervalModel
    {
        $initialWords = $this->patternStorage->getIntervalInitialWords();
        $separators = $this->patternStorage->getIntervalSeparators();
        $intervalParts = $this->getIntervalParts($row, $initialWords, $separators);
        if (!$intervalParts) {
            throw InvalidIntervalException::create($row);
        }

        try {
            $initialDateModel = $this->convertToDate($intervalParts[0]);
            $finalDateModel = $this->convertToDate($intervalParts[1]);
            return new DateIntervalModel($initialDateModel, $finalDateModel);
        } catch (ConvertToDateException $exception) {
            throw ConvertToDateIntervalException::create($row);
        }
    }

    private function getRowParts(string $row, array $separators): ?array
    {
        foreach ($separators as $separator) {
            $parts = explode($separator, $row);
            if (count($parts) > 1) {
                return $parts;
            }
        }

        return null;
    }

    /**
     * @param string $row
     * @param array $initialWords
     * @param array $separators
     * @return array|null
     */
    private function getIntervalParts(string $row, array $initialWords, array $separators): ?array
    {
        /** remove initial word */
        $initialWordsPattern = '/^(' . implode('|', $initialWords) . ')(.*)/';
        if (preg_match($initialWordsPattern, $row)) {
            $row = preg_replace($initialWordsPattern, '$2', $row);
        }
        foreach ($separators as $separator) {
            $inputParts = explode($separator, $row);
            if (count($inputParts) === 2) {
                return $inputParts;
            }
        }

        return null;
    }
}