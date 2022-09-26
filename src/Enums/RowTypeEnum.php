<?php

namespace Ruslanovich\DateConverter\Enums;

enum RowTypeEnum
{
    case SIMPLE_DATE;
    case DATE_COLLECTION;
    case DATE_INTERVAL;
    case UNDEFINED;
}