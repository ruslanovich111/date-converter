<?php

namespace Ruslanovich\DateConverter\Models;

/**
 * Model for intervals search in a text
 */
class TextIntervalMatch
{
    /**
     * Interval regex pattern
     * @var string
     */
    private string $intervalPattern;

    /**
     * @var string
     */
    private string $originalText;

    /**
     * Text with marked matches of dateIntervals
     * @var string
     */
    private string $textWithMatches;

    /**
     * @var DateIntervalCollection
     */
    private DateIntervalCollection $dateIntervalCollection;

    /**
     * @param string $intervalPattern
     * @param string $originalText
     * @param string $textWithMatches
     * @param DateIntervalCollection $dateIntervalCollection
     */
    public function __construct(string $intervalPattern, string $originalText, string $textWithMatches, DateIntervalCollection $dateIntervalCollection)
    {
        $this->intervalPattern = $intervalPattern;
        $this->originalText = $originalText;
        $this->textWithMatches = $textWithMatches;
        $this->dateIntervalCollection = $dateIntervalCollection;
    }

    /**
     * @return string
     */
    public function getIntervalPattern(): string
    {
        return $this->intervalPattern;
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
     * @return DateIntervalCollection
     */
    public function getDateIntervalCollection(): DateIntervalCollection
    {
        return $this->dateIntervalCollection;
    }
}