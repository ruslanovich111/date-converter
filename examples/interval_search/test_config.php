<?php
return [
    'patterns' => [
        '\s?($day) ($month) ($year)\s?',
        '\s?the ($day)th of ($month) ($year)\s?',
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
