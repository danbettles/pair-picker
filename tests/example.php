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
    ])
    //Prevent the stable pairings from before.
    ->withoutPairing(['Carol', 'David'])
    ->withoutPairing(['Dan', 'Neil'])
    ->withoutPairing(['Mark', 'Sean'])
    ->withoutPairing(['Jason', 'Chris'])
    ->withoutPairing(['Vikki', 'Marianne'])
    ->withoutPairing(['Charlotte', 'Tori'])
    ->withoutPairing(['Deborah', 'Vaishali'])
;

$startDate = '2015-06-25';

$csv = '';

foreach ($uniqueCombinations->getArray() as $i => $pairings) {
    $numWeeksElapsed = $i * 3;
    $time = strtotime("{$startDate} +{$numWeeksElapsed} weeks");

    $csv .= sprintf("\"%s\"\n\n", date('d F, Y', $time));

    foreach ($pairings->getArray() as $pair) {
        $csv .= sprintf("\"%s\",\"%s\"\n", reset($pair), end($pair));
    }

    $csv .= "\n";
}

print $csv;
