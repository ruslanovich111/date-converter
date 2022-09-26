<?php

namespace Ruslanovich\DateConverter\Models;

/**
 * The model stores the found dates in the text according to the rejex pattern
 */
class TextPatternMatch
{
    /**
     * Regex pattern for text search
     * @var PatternModel
     */
    private PatternModel $patternModel;

    /**
     * Original text
     * @var string
     */
    private string $originalText;

    /**
     * Text with marked matches dates
     * @var string
     */
    private string $textWithMatches;

    /**
     * Collection of dates which matches to rejex pattern
     * @var DateCollection
     */
    private DateCollection $dateModelCollection;

    /**
     * @param PatternModel $pattern
     * @param string $originalText
     * @param string $textWithMatches
     * @param DateCollection $dateModelCollection
     */
    public function __construct(PatternModel $pattern, string $originalText, string $textWithMatches, DateCollection $dateModelCollection)
    {
        $this->patternModel = $pattern;
        $this->originalText = $originalText;
        $this->textWithMatches = $textWithMatches;
        $this->dateModelCollection = $dateModelCollection;
    }

    /**
     * @return PatternModel
     */
    public function getPatternModel(): PatternModel
    {
        return $this->patternModel;
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
     * @return DateCollection
     */
    public function getDateCollection(): DateCollection
    {
        return $this->dateModelCollection;
    }
}