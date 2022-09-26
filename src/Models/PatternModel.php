<?php

namespace Ruslanovich\DateConverter\Models;

/**
 * The model stores regex pattern from config file
 */
class PatternModel
{
    /**
     * Sequence number in the configuration file
     * @var int
     */
    private int $id;

    /**
     * Regular expression
     * @var string
     */
    private string $pattern;

    /**
     * Place day group in regular expression
     * @var int|null
     */
    private ?int $dayPlace;

    /**
     * Place month group in regular expression
     * @var int|null
     */
    private ?int $monthPlace;

    /**
     * Place year group in regular expression
     * @var int|null
     */
    private ?int $yearPlace;

    /**
     * @param int $id
     * @param string $pattern
     * @param int|null $dayPlace
     * @param int|null $monthPlace
     * @param int|null $yearPlace
     */
    public function __construct(
        int    $id,
        string $pattern,
        ?int   $dayPlace,
        ?int   $monthPlace,
        ?int   $yearPlace
    )
    {
        $this->id = $id;
        $this->pattern = $pattern;
        $this->dayPlace = $dayPlace;
        $this->monthPlace = $monthPlace;
        $this->yearPlace = $yearPlace;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getDayPlace(): ?int
    {
        return $this->dayPlace;
    }

    /**
     * @return int|null
     */
    public function getMonthPlace(): ?int
    {
        return $this->monthPlace;
    }

    /**
     * @return int|null
     */
    public function getYearPlace(): ?int
    {
        return $this->yearPlace;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}