<?php

namespace Ruslanovich\DateConverter\Models;

/**
 * Model for search with replacement
 */
class TextAllPatternMatches
{
    /**
     * @var string
     */
    private string $originalText;

    /**
     * Text with all marked regex pattern
     * @var string
     */
    private string $textWithMatches;

    /**
     * Each found pattern corresponds to several DateModels
     *
     * Array of the form [ 'pattern_id' => DateCollection ]
     * @var DateCollection[]
     */
    private array $patternDatesMatches;

    /**
     * All regex patterns found in text
     *
     * Array of the form [ 'pattern_id' => PatternModel ]
     * @var PatternModel[]
     */
    private array $patterns;

    public function addPatternDatesMatch(PatternModel $pattern, DateCollection $dates)
    {
        $this->patternDatesMatches[$pattern->getId()] = $dates;
        $this->patterns[$pattern->getId()] = $pattern;
    }

    /**
     * @param string $originalText
     */
    public function setOriginalText(string $originalText): void
    {
        $this->originalText = $originalText;
    }

    /**
     * @param string $textWithMatches
     */
    public function setTextWithMatches(string $textWithMatches): void
    {
        $this->textWithMatches = $textWithMatches;
    }

    /**
     * @return string
     */
    public function getOriginalText(): string
    {
        return $this->originalText;
    }

    /**
     * @return string
     */
    public function getTextWithMatches(): string
    {
        return $this->textWithMatches;
    }

    /**
     * @return DateCollection[]
     */
    public function getPatternDatesMatches(): array
    {
        return $this->patternDatesMatches;
    }

    /**
     * @param int $patternId
     * @return DateCollection
     */
    public function getMatchDatesForPattern(int $patternId): DateCollection
    {
        return $this->patternDatesMatches[$patternId];
    }

    /**
     * @return PatternModel[]
     */
    public function getAllMatchPatterns(): array
    {
        return $this->patterns;
    }

    /**
     * @return DateCollection
     */
    public function getAllMatchDates(): DateCollection
    {
        $dateCollection = new DateCollection();
        foreach ($this->getPatternDatesMatches() as $dateCollection) {
            foreach ($dateCollection->getAll() as $dateModel) {
                $dateCollection->addDateModel($dateModel);
            }
        }

        return $dateCollection;
    }
}