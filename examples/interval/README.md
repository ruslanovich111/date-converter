**Configuration:**\
Add two fields `interval_separators`, `interval_initial_words` to the configuration file.
`interval_separators` - contains interval separators.
`interval_initial_words` - words that intervals can start with.
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
];
```
**Usage:**\
Rows of the form:
- from (date_pattern) to (date_pattern)
- (date_pattern) to (date_pattern)
- from (date_pattern) - (date_pattern)
- (date_pattern) - (date_pattern)
can be convert by `convertToInterval` to `DateIntervalModel`.
