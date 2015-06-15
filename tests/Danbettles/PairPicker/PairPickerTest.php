<?php
/**
 * @copyright Copyright (c) 2015, Dan Bettles
 * @license http://www.opensource.org/licenses/MIT MIT
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */

namespace Tests\Danbettles\PairPicker\PairPicker;

use Danbettles\PairPicker\PairPicker;
use Danbettles\PairPicker\Pairings;
use Danbettles\PairPicker\PairingsCollection;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        new PairPicker();
    }

    public static function providesUniqueCombinations()
    {
        return [
            [
                new PairingsCollection([
                    new Pairings([['foo', 'bar']]),
                ]),
                [
                    'foo',
                    'bar',
                ],
            ],
            [
                new PairingsCollection([
                    new Pairings([['foo', 'bar'], ['baz', null]]),
                    new Pairings([['foo', 'baz'], ['bar', null]]),
                    new Pairings([['foo', null], ['bar', 'baz']]),
                ]),
                [
                    'foo',
                    'bar',
                    //--
                    'baz',
                    //Short a person.
                ],
            ],
            [
                new PairingsCollection([
                    new Pairings([['foo', 'bar'], ['baz', 'qux']]),
                    new Pairings([['foo', 'baz'], ['bar', 'qux']]),
                    new Pairings([['foo', 'qux'], ['bar', 'baz']]),
                ]),
                [
                    'foo',
                    'bar',
                    //--
                    'baz',
                    'qux',
                ],
            ],
            [
                new PairingsCollection([
                    new Pairings([['foo', 'bar'], ['baz', 'qux'], ['norf', null]]),
                    new Pairings([['foo', 'baz'], ['bar', 'norf'], ['qux', null]]),
                    new Pairings([['foo', 'qux'], ['bar', null], ['baz', 'norf']]),
                    new Pairings([['foo', 'norf'], ['bar', 'qux'], ['baz', null]]),
                    new Pairings([['foo', null], ['bar', 'baz'], ['qux', 'norf']]),
                ]),
                [
                    'foo',
                    'bar',
                    //--
                    'baz',
                    'qux',
                    //--
                    'norf',
                    //Short a person.
                ],
            ],
            [
                new PairingsCollection([
                    new Pairings([['foo', 'bar'], ['baz', 'qux'], ['norf', 'poop']]),
                    new Pairings([['foo', 'baz'], ['bar', 'norf'], ['qux', 'poop']]),
                    new Pairings([['foo', 'qux'], ['bar', 'poop'], ['baz', 'norf']]),
                    new Pairings([['foo', 'norf'], ['bar', 'qux'], ['baz', 'poop']]),
                    new Pairings([['foo', 'poop'], ['bar', 'baz'], ['qux', 'norf']]),
                ]),
                [
                    'foo',
                    'bar',
                    //--
                    'baz',
                    'qux',
                    //--
                    'norf',
                    'poop',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providesUniqueCombinations
     */
    public function testCreateuniquecombinationsCreatesAsManyUniqueCombinationsAsPossible($expectedCombinations, $people)
    {
        $picker = new PairPicker();
        $actualCombinations = $picker->createUniqueCombinations($people);

        $this->assertEquals($expectedCombinations, $actualCombinations);
    }

    public static function providesPeopleArraysThatAreTooShort()
    {
        return [
            [
                [],
            ],
            [
                ['foo'],
            ],
        ];
    }

    /**
     * @dataProvider providesPeopleArraysThatAreTooShort
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage There are insufficient people.
     */
    public function testCreateuniquecombinationsThrowsAnExceptionIfTheArrayOfPeopleIsTooShort($people)
    {
        $picker = new PairPicker();
        $picker->createUniqueCombinations($people);
    }

    public static function providesPeopleArraysContainingDuplicates()
    {
        return [
            [
                ['foo', 'foo'],
            ],
            [
                ['foo', 'bar', 'foo'],
            ],
        ];
    }

    /**
     * @dataProvider providesPeopleArraysContainingDuplicates
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage A person appears more than once.
     */
    public function testCreateuniquecombinationsThrowsAnExceptionIfTheArrayOfPeopleContainsDuplicates($people)
    {
        $picker = new PairPicker();
        $picker->createUniqueCombinations($people);
    }

    public function testCreateReturnsANewInstance()
    {
        $picker = PairPicker::create();

        $this->assertInstanceOf('Danbettles\PairPicker\PairPicker', $picker);
    }
}
