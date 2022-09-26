<?php

namespace Ruslanovich\DateConverter\Models;

class TextPatternSequence
{
    /**
     * @var TextPatternMatch[]
     */
    private array $textPatternMatches = [];

    public function add(TextPatternMatch $textMatchesModel): void
    {
        $this->textPatternMatches[$textMatchesModel->getPatternModel()->getId()] = $textMatchesModel;
    }

    public function getAll(): array
    {
        return $this->textPatternMatches;
    }

    public function getTextPatternMatch(int $patternId): ?TextPatternMatch
    {
        if (!array_key_exists($patternId, $this->textPatternMatches)) {
            return null;
        }

        return $this->textPatternMatches[$patternId];
    }
}