<?php

namespace Ruslanovich\DateConverter\Storages\PatternStorages;

use Ruslanovich\DateConverter\Enums\MonthNumberEnum;
use Ruslanovich\DateConverter\Exceptions\InvalidPatternResourceException;
use Ruslanovich\DateConverter\Models\PatternModel;
use Ruslanovich\DateConverter\Models\PatternCollection;

class ArrayPatternStorage implements PatternStorageInterface
{
    /**
     * @var array
     */
    private array $config;
    private const DAY_EXPRESSION = '[0-9]{1,2}';
    private const YEAR_EXPRESSION = '[0-9]{4}';

    /**
     * @throws InvalidPatternResourceException
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        if (!$this->validResource($this->config)) {
            throw InvalidPatternResourceException::create();
        }
    }

    private function validResource(array $patternResource): bool
    {
        if (!array_key_exists('patterns', $patternResource) ||
            !array_key_exists('months', $patternResource)) {
            return false;
        }
        if (!is_array($patternResource['patterns']) ||
            !is_array($patternResource['months'])) {
            return false;
        }

        if (count($patternResource['months']) !== 12) {
            return false;
        }

        return true;
    }

    private function substituteVariables(string $pattern): string
    {
        $months = [];
        foreach ($this->config['months'] as $montPresentations) {
            $months = array_merge($months, $montPresentations);
        }
        $monthExpression = implode("|", $months);

        $pattern = str_replace('$month', $monthExpression, $pattern);
        $pattern = str_replace('$day', self::DAY_EXPRESSION, $pattern);
        return str_replace('$year', self::YEAR_EXPRESSION, $pattern);
    }

    /**
     * @return PatternCollection
     */
    public function getPatternCollection(): PatternCollection
    {
        $collection = new PatternCollection();
        foreach ($this->config['patterns'] as $id => $pattern) {
            $collection->addPattern(new PatternModel(
                id: $id,
                pattern: $this->substituteVariables($pattern),
                dayPlace: $this->getDayPlace($pattern),
                monthPlace: $this->getMonthPlace($pattern),
                yearPlace: $this->getYearPlace($pattern)
            ));
        }

        return $collection;
    }

    private function getDayPlace(string $pattern): ?int
    {
        if (!strpos($pattern, '$day')) {
            return null;
        }

        $positions = array_filter([
            'day' => strpos($pattern, '$day'),
            'month' => strpos($pattern, '$month'),
            'year' => strpos($pattern, '$year')
        ]);
        asort($positions, SORT_NUMERIC);

        return array_search('day', array_keys($positions)) + 1;
    }

    private function getMonthPlace(string $pattern): ?int
    {
        if (!strpos($pattern, '$month')) {
            return null;
        }

        $positions = array_filter([
            'day' => strpos($pattern, '$day'),
            'month' => strpos($pattern, '$month'),
            'year' => strpos($pattern, '$year')
        ]);
        asort($positions, SORT_NUMERIC);

        return array_search('month', array_keys($positions)) + 1;
    }

    private function getYearPlace(string $pattern): ?int
    {
        if (!strpos($pattern, '$year')) {
            return null;
        }

        $positions = array_filter([
            'day' => strpos($pattern, '$day'),
            'month' => strpos($pattern, '$month'),
            'year' => strpos($pattern, '$year')
        ]);
        asort($positions, SORT_NUMERIC);

        return array_search('year', array_keys($positions)) + 1;
    }

    public function getMonthNumber(string $monthName): ?MonthNumberEnum
    {
        $monthInLowercase = mb_strtolower($monthName);
        foreach ($this->config['months'] as $monthNumber => $montPresentations) {
            if (in_array($monthInLowercase, $montPresentations) ||
                in_array($monthName, $montPresentations)) {
                return MonthNumberEnum::from($monthNumber);
            }
        }

        return null;
    }

    public function getCollectionSeparators(): array
    {
        return $this->config['collection_separators'];
    }

    public function getIntervalSeparators(): array
    {
        return $this->config['interval_separators'];
    }

    public function getIntervalInitialWords(): array
    {
        return $this->config['interval_initial_words'];
    }
}