<?php

use Ruslanovich\DateConverter\Services\TextToModelMapper;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$config = require_once __DIR__ . '/test_patterns.php';
$patternStorage = new ArrayPatternStorage($config);

$converter = new TextToModelMapper($patternStorage);
$textAllPatternMatches = $converter->mapAllPatternsTogether("It was sunny outside on the 12th of April 2022, 13 April 2022 and the 17th of April 2021");

/** Next, we interact with the TextAllPatternMatches model */

/** to get text with found matches */
var_dump($textAllPatternMatches->getTextWithMatches());
/**
 * The output is text "It was sunny outside on $pattern_1, $pattern_2 and $pattern_1",
 * in which the rows "the 12th of April 2022" "the 17th of April 2021" matches to first pattern in test_config.php and replaced with $pattern_1
 *
 * The row "13 April 2022"  matches to second pattern and replaced with $pattern_2
 */

/** to get all dates matching the first pattern (i.e. $pattern_1) */
var_dump($textAllPatternMatches->getMatchDatesForPattern(1));

/** to get all found patterns */
var_dump($textAllPatternMatches->getAllMatchPatterns());

/** to get all found dates */
var_dump($textAllPatternMatches->getAllMatchDates());

