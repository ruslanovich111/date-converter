<?php

use Ruslanovich\DateConverter\Services\RowToModelConverter;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$config = require_once __DIR__ . '/test_config.php';
$patternStorage = new ArrayPatternStorage($config);

$converter = new RowToModelConverter($patternStorage);
var_dump($converter->convertToDateCollection("The 12th of April 2022;13.04.2022")->getAll());
var_dump($converter->getRowType("The 12th of April 2022;13.04.2022"));
