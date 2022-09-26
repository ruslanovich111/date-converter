<?php

use Ruslanovich\DateConverter\Services\RowToModelConverter;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;
use Ruslanovich\DateConverter\Storages\PatternStorages\MultiplePatternStorage;

require __DIR__ . './../../vendor/autoload.php';

$firstConfig = require_once __DIR__ . '/first_config.php';
$secondConfig = require_once __DIR__ . '/second_config.php';

$storage = new MultiplePatternStorage([
    new ArrayPatternStorage($firstConfig),
    new ArrayPatternStorage($secondConfig),
]);

$converter = new RowToModelConverter($storage);
var_dump($converter->convertToDateCollection("The 12th of April 2022;8 März 2023;19 апреля 2022")->getAll());

