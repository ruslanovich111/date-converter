<?php

namespace Ruslanovich\DateConverter\Models;

class PatternCollection
{
    /**
     * @var PatternModel[]
     */
    private array $patternModels = [];

    /**
     * @param PatternModel $patternModel
     * @return void
     */
    public function addPattern(PatternModel $patternModel)
    {
        $this->patternModels[] = $patternModel;
    }

    /**
     * @return PatternModel[]
     */
    public function getPatternModels(): array
    {
        return $this->patternModels;
    }
}