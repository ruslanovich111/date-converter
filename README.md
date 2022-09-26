# Description
The library provides extended functionality for working with dates. 

- converting date rows  "The 13th of Mar. 1999", "Mar. 2022"  to objects.
- converting date rows in different languages "8 März 2023"
- converting date intervals "13th of Mar. 1999 - 8 März 2023"
- converting date sequences "The 12th of April 2022; 8 März 2023"
- search dates in a text in your language...

The library solves all these problems.

# Configuration
Create `ArrayPatternStorage`.\
The object takes config array of a strictly defined format:
- The `patterns` field should contain regular expressions for dates.
- The `months` field should contain regular expressions for months. There should be exactly 12 of them.

```
<?php

$patternStorage = new ArrayPatternStorage([
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
]);
```

The library automatically substitutes regular expressions:
`$day = [0-9]{1,2}`, `$year = [0-9]{4}`, `$month = January|Jan\.|February|...`.

# Convertation
**All possible examples of using the library are in the examples folder.**\
For example, in ./examples/simple_date/test.php the simple convertation is described:
```
/** $patternStorage defined above */
$patternStorage = ...

$converter = new RowToModelConverter($patternStorage);
$converter->convertToDate("12th February 2022");
```
The `convertToDate` method will return a `DateModel` object since the string "12th February 2022" matches the first pattern in
configuration file.\
If you pass a string that does not match any of the patterns, then an Exception will be thrown.\
The order of the patterns in the configuration is important because the `convertToDate` method returns a `DateModel` based on the first matching pattern!


### Advanced options
Interval convertation: [interval-convertation](exapmles/interval/README.md)\
Sequence convertation: [secuence-convertation](exapmles/secuence/README.md)\
Multiple pattern storages: [multiple-storages](exapmles/multiple_storages/README.md)

# Search
The library provides two search strategies:
- search with replacement
- search with repetitions

**Examples of using search are described in the folder examples/search.**
Next, let's explain the differences.\
Let the input row be given:\
`It was sunny outside on the 12th of April 2022, 13 April 2022 and the 17th of April 2021`

### Search with replacement
- find all dates for the input corresponding to the first pattern, replace with $pattern_1, save the transformed row:\
`It was sunny outside on $pattern_1, 13 April 2022 and $pattern_1`.\
The dates for pattern 1 are stored in the TextAllPatternMatches model.
- In the transformed row (with $pattern_1) we find the dates for the pattern 2, replace it with $pattern_2, save the transformed row:\
`It was sunny outside on $pattern_1, $pattern_2 and $pattern_1`.\
The dates for pattern 2 are stored in the TextAllPatternMatches model.
- etc...

For this strategy, the order of the patterns in the configuration is important!

### Search with repetitions
- find all dates for the input corresponding to the first pattern, replace with $pattern_1, save the transformed row:\
  `It was sunny outside on $pattern_1, 13 April 2022 and $pattern_1`.\
  The dates for pattern 1 are stored in the TextPattern model.
- again we take the input row and find the dates corresponding to pattern 2, replace it with $pattern_2, save string:\
`It was sunny outside on the 12th of April 2022, $pattern_2 and the 17th of April 2021`,\
The dates for pattern 2 are stored in the TextPattern model.
- etc...

Thus the TextPatternSequence is fill with the TextPattern models.
The order is not important for this strategy.

### Advanced options
Interval search: [interval-search](exapmles/interval_search/README.md)
