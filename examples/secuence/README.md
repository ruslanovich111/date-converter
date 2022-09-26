
**Configuration:**\
Add field `collection_separators` to configuration file.\
Configuration example:
```
<?php
return [
    'patterns' => [
        '($day)th ($month) ($year)',
        'The ($day)th of ($month) ($year)',
    ],
    'months' => [
        1 => ["January", "Jan\."],
        2 => ["February", "Febr\."],
        3 => ["March", "Mar\."],
        4 => ["April"],
        5 => ["May"],
        6 => ["June"],
        7 => ["July"],
        8 => ["August"],
        9 => ["September"],
        10 => ["October"],
        11 => ["November"],
        12 => ["December"]
    ],
    'interval_separators' => ['-', 'to'],
    'interval_initial_words' => ['from'],
    'collection_separators' => ['and', ';']
];
```
**Usage:**\
Rows of the form:
- (date_pattern) and (date_pattern) and (date_pattern) ...
- (date_pattern); (date_pattern); (date_pattern); ...
- (date_pattern); (date_pattern) and (date_pattern); ...
may be convert by `convertToDateCollection` to `DateCollection`.

**Row type definition:**\
If `interval_separators`, `interval_initial_words`, `collection_separators`,\
fields are added to the configuration file then we can to define type `RowTypeEnum` of row:
```
$converter->getRowType("The 12th of April 2022;13.04.2022");
```
There are 4 types `SIMPLE_DATE`, `DATE_COLLECTION`, `DATE_INTERVAL`, `UNDEFINED`.\