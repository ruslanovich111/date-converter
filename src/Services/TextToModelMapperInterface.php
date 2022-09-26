<?php

namespace Ruslanovich\DateConverter\Services;

use Ruslanovich\DateConverter\Models\TextAllPatternMatches;
use Ruslanovich\DateConverter\Models\TextIntervalMatch;
use Ruslanovich\DateConverter\Models\TextPatternSequence;

interface TextToModelMapperInterface
{
    public function mapEachPatternSeparately(string $text): TextPatternSequence;
    public function mapAllPatternsTogether(string $text): TextAllPatternMatches;
    public function mapToInterval(string $text, string $initialWord, string $separator): TextIntervalMatch;
}