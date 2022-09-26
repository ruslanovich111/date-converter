<?php

use Ruslanovich\DateConverter\Services\RowToModelConverter;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$config = require_once __DIR__ . '/test_patterns.php';
$patternStorage = new ArrayPatternStorage($config);

$converter = new RowToModelConverter($patternStorage);
var_dump($converter->convertToDate("12th February 2022"));
