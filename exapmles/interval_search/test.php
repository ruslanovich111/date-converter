<?php

use Ruslanovich\DateConverter\Services\TextToModelMapper;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$config = require_once __DIR__ . '/test_patterns.php';
$patternStorage = new ArrayPatternStorage($config);

$converter = new TextToModelMapper($patternStorage);
$textIntervalMatch = $converter->mapToInterval(
    "I was on vacation from 13 April 2022 to the 17th of April 2021 ",
    "from",
    "to"
);

/** Next, we interact with the TextIntervalMatch model */

/** to get a text with matches */
var_dump($textIntervalMatch->getTextWithMatches());
/**
 * The output is text "I was on vacation $interval"
 */

/** to get the interval pattern */
var_dump($textIntervalMatch->getIntervalPattern());

/** to get all DateIntervals found in the text */
var_dump($textIntervalMatch->getDateIntervalCollection()->getDateIntervals());
