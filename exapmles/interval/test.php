<?php

use Ruslanovich\DateConverter\Services\RowToModelConverter;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$config = require_once __DIR__ . '/test_patterns.php';
$patternStorage = new ArrayPatternStorage($config);

$converter = new RowToModelConverter($patternStorage);
$interval = $converter->convertToInterval("from The 12th of April 2022 to 13 April 2022");

/** to get initial date */
var_dump($interval->getInitialDate());

/** to get final date */
var_dump($interval->getFinalDate());