<?php

use Ruslanovich\DateConverter\Services\TextToModelMapper;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$config = require_once __DIR__ . '/test_config.php';
$patternStorage = new ArrayPatternStorage($config);

$converter = new TextToModelMapper($patternStorage);
$textPatternSequence = $converter->mapEachPatternSeparately("It was sunny outside on the 12th of April 2022, 13 April 2022 and the 17th of April 2021");

/** Next, we interact with the TextPatternSequence model */

/** to get text with found matches for pattern 1 */
var_dump($textPatternSequence->getTextPatternMatch(1)->getTextWithMatches());
/** result: "It was sunny outside on $pattern_1, 13 April 2022 and $pattern_1" */

/** to get text with found matches for pattern 2 */
var_dump($textPatternSequence->getTextPatternMatch(2)->getTextWithMatches());
/** result: "It was sunny outside on the 12th of April 2022, $pattern_2 and the 17th of April 2021" */

/** to get all match dates for pattern 1 */
var_dump($textPatternSequence->getTextPatternMatch(1)->getDateCollection()->getAll());

/** to get all match dates for pattern 2 */
var_dump($textPatternSequence->getTextPatternMatch(2)->getDateCollection()->getAll());
