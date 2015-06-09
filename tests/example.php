<?php
/**
 * @copyright Copyright (c) 2015, Dan Bettles
 * @license http://www.opensource.org/licenses/MIT MIT
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Danbettles\PairPicker\PairPicker;

$picker = new PairPicker();

$uniqueCombinations = $picker->createUniqueCombinations([
    'Carol',
    'David',
    'Dan',
    'Neil',
    'Lindsey',
    'Lisa',
    'Mark',
    'Sean',
    'Jason',
    'Chris',
    'Victoria',
    'Marianne',
    'Charlotte',
    'Tori',
    'Deborah',
    'Vaishali',
    'Lewis',
    'Beth',
    'Gary',
    'Alan',
]);

$startDate = '2015-07-02';

$csv = '';

foreach ($uniqueCombinations as $i => $pairings) {
    $numWeeksElapsed = $i * 3;
    $time = strtotime("{$startDate} +{$numWeeksElapsed} weeks");

    $csv .= date('d F, Y', $time) . "\n\n";

    foreach ($pairings->getArray() as $pair) {
        $first = reset($pair);
        $last = end($pair);
        $csv .= "{$first},{$last}\n";
    }

    $csv .= "\n";
}

print $csv;
