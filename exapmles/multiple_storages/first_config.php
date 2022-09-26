<?php
return [
    'patterns' => [
        '($day)th ($month) ($year)',
        'The ($day)th of ($month) ($year)',
        '($day) ($month) ($year)',
        '($day)\.($month)\.($year)',
    ],
    'months' => [
        1 => ["01", "January", "Jan\."],
        2 => ["02", "February", "Febr\."],
        3 => ["03", "March", "Mar\."],
        4 => ["04", "April"],
        5 => ["05", "May"],
        6 => ["06", "June"],
        7 => ["07", "July"],
        8 => ["08", "August"],
        9 => ["09", "September"],
        10 => ["10", "October"],
        11 => ["11", "November"],
        12 => ["12", "December"]
    ],
    'interval_separators' => ['to'],
    'interval_initial_words' => ['from'],
    'collection_separators' => ['and']
];
