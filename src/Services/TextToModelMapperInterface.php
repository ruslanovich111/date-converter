<?php

namespace Ruslanovich\DateConverter\Services;

use Ruslanovich\DateConverter\Models\TextAllPatternMatches;
use Ruslanovich\DateConverter\Models\TextIntervalMatch;
use Ruslanovich\DateConverter\Models\TextPatternSequence;

interface TextToModelMapperInterface
{
    /**
     * @param string $text
     * @return TextPatternSequence
     */
    public function mapEachPatternSeparately(string $text): TextPatternSequence;

    /**
     * @param string $text
     * @return TextAllPatternMatches
     */
    public function mapAllPatternsTogether(string $text): TextAllPatternMatches;

    /**
     * @param string $text
     * @param string $initialWord
     * @param string $separator
     * @return TextIntervalMatch
     */
    public function mapToInterval(string $text, string $initialWord, string $separator): TextIntervalMatch;
}