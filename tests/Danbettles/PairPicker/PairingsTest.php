<?php
/**
 * @copyright Copyright (c) 2015, Dan Bettles
 * @license http://www.opensource.org/licenses/MIT MIT
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */

namespace Tests\Danbettles\PairPicker\Pairings;

use Danbettles\PairPicker\Pairings;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $pairingsArray = [['foo', 'bar'], ['baz', 'qux']];
        $pairings = new Pairings($pairingsArray);

        $this->assertEquals($pairingsArray, $pairings->getArray());

        $emptyPairings = new Pairings();

        $this->assertEquals([], $emptyPairings->getArray());
    }

    public function testContainsReturnsTrueIfTheCollectionContainsTheSpecifiedPairing()
    {
        $pairingsArray = [['foo', 'bar'], ['baz', 'qux']];
        $pairings = new Pairings($pairingsArray);

        $this->assertTrue($pairings->contains(['foo', 'bar']));
        $this->assertTrue($pairings->contains(['bar', 'foo']));
        $this->assertTrue($pairings->contains(['baz', 'qux']));
        $this->assertTrue($pairings->contains(['qux', 'baz']));

        $this->assertFalse($pairings->contains(['foo', 'baz']));
        $this->assertFalse($pairings->contains(['foo', 'qux']));
        $this->assertFalse($pairings->contains(['bar', 'baz']));
        $this->assertFalse($pairings->contains(['bar', 'qux']));
    }

    public function testAddAddsAPairToTheCollection()
    {
        $pairings = new Pairings();

        $pairings->add(['foo', 'bar']);

        $this->assertEquals([['foo', 'bar']], $pairings->getArray());

        $pairings->add(['baz', 'qux']);

        $this->assertEquals([['foo', 'bar'], ['baz', 'qux']], $pairings->getArray());
    }

    public function testAddReturnsTheCollection()
    {
        $pairings = new Pairings();
        $something = $pairings->add(['foo', 'bar']);

        $this->assertSame($pairings, $something);
    }

    public static function providesPairingsArrays()
    {
        return [
            [
                [],
            ],
            [
                [['foo', 'bar']],
            ],
            [
                [['foo', 'bar'], ['baz', 'qux']],
            ],
        ];
    }

    /**
     * @dataProvider providesPairingsArrays
     */
    public function testCopyReturnsACopyOfTheCollection($pairingsArray)
    {
        $pairings = new Pairings($pairingsArray);
        $clone = $pairings->copy();

        $this->assertNotSame($pairings, $clone);
        $this->assertEquals($pairings, $clone);
    }
}
