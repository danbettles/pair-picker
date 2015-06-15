<?php
/**
 * @copyright Copyright (c) 2015, Dan Bettles
 * @license http://www.opensource.org/licenses/MIT MIT
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Danbettles\PairPicker\PairPicker;

$uniqueCombinations = PairPicker::create()
    ->createUniqueCombinations([
        'Lewis',
        'Vaishali',
        'Deborah',
        'Tori',
        'Charlotte',
        'Sean',
        'Mark',
        'Lisa',
        'Neil',
        'Vikki',
        'Chris',
        'Dan',
        'Marianne',
        'Jason',
        'David',
        'Carol',
        'Lindsey',
    ])
//    ->withoutPairing(['Carol', 'David'])
//    ->withoutPairing(['Dan', 'Neil'])
//    ->withoutPairing(['Lindsey', 'Lisa'])
//    ->withoutPairing(['Mark', 'Sean'])
//    ->withoutPairing(['Jason', 'Chris'])
//    ->withoutPairing(['Vikki', 'Marianne'])
//    ->withoutPairing(['Charlotte', 'Tori'])
//    ->withoutPairing(['Deborah', 'Vaishali'])
;

$startDate = '2015-07-02';

$csv = '';

foreach ($uniqueCombinations->getArray() as $i => $pairings) {
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
