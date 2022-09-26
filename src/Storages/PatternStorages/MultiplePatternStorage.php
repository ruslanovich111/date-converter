<?php

namespace Ruslanovich\DateConverter\Storages\PatternStorages;

use Ruslanovich\DateConverter\Enums\MonthNumberEnum;
use Ruslanovich\DateConverter\Exceptions\InvalidMultipleStorageException;
use Ruslanovich\DateConverter\Models\PatternCollection;

class MultiplePatternStorage implements PatternStorageInterface
{
    /**
     * @var PatternStorageInterface[]
     */
    private array $patternStorages = [];

    /**
     * @param array $patternStorages
     * @throws InvalidMultipleStorageException
     */
    public function __construct(array $patternStorages)
    {
        $this->patternStorages = $patternStorages;
        $this->validate($this->patternStorages);
    }

    private function validate(array $patternStorages): void
    {
        foreach ($patternStorages as $storage) {
            if (!($storage instanceof PatternStorageInterface)) {
                throw InvalidMultipleStorageException::create();
            }
        }
    }

    public function getPatternCollection(): PatternCollection
    {
        $patternCollection = new PatternCollection();
        /** @var PatternStorageInterface $storage */
        foreach ($this->patternStorages as $storage) {
            foreach ($storage->getPatternCollection()->getPatternModels() as $patternModel) {
                $patternCollection->addPattern($patternModel);
            }
        }

        return $patternCollection;
    }

    public function getMonthNumber(string $monthName): ?MonthNumberEnum
    {
        /** @var PatternStorageInterface $storage */
        foreach ($this->patternStorages as $storage) {
            if($storage->getMonthNumber($monthName)){
                return $storage->getMonthNumber($monthName);
            }
        }

        return null;
    }

    public function getCollectionSeparators(): array
    {
        $separators = [];
        /** @var PatternStorageInterface $storage */
        foreach ($this->patternStorages as $storage) {
            $separators = array_merge($separators, $storage->getCollectionSeparators());
        }

        return $separators;
    }

    public function getIntervalSeparators(): array
    {
        $separators = [];
        /** @var PatternStorageInterface $storage */
        foreach ($this->patternStorages as $storage) {
            $separators = array_merge($separators, $storage->getIntervalSeparators());
        }

        return $separators;
    }

    public function getIntervalInitialWords(): array
    {
        $initialWords = [];
        /** @var PatternStorageInterface $storage */
        foreach ($this->patternStorages as $storage) {
            $initialWords = array_merge($initialWords, $storage->getIntervalInitialWords());
        }

        return $initialWords;
    }

}