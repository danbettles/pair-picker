<?php
/**
 * @copyright Copyright (c) 2015, Dan Bettles
 * @license http://www.opensource.org/licenses/MIT MIT
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */

namespace Tests\Danbettles\PairPicker\PairingsCollection;

use Danbettles\PairPicker\PairingsCollection;
use Danbettles\PairPicker\Pairings;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $empty = new PairingsCollection();

        $this->assertEquals([], $empty->getArray());

        $something = [new Pairings([['foo', 'bar']])];
        $nonEmpty = new PairingsCollection($something);

        $this->assertEquals($something, $nonEmpty->getArray());
    }

    public function testAddAddsAPairingsToTheCollection()
    {
        $pairings = new Pairings([['foo', 'bar']]);
        $collection = new PairingsCollection();
        $collection->add($pairings);

        $this->assertEquals([$pairings], $collection->getArray());
    }

    public function testAddReturnsTheCollection()
    {
        $collection = new PairingsCollection();
        $something = $collection->add(new Pairings([['foo', 'bar']]));

        $this->assertSame($collection, $something);
    }

    public function testContainspairingReturnsTrueIfTheSpecifiedPairingExistsInAnyOfThePairings()
    {
        $collection = new PairingsCollection();

        $this->assertFalse($collection->containsPairing(['foo', 'bar']));

        $collection->add(new Pairings([['foo', 'bar']]));

        $this->assertTrue($collection->containsPairing(['foo', 'bar']));
        $this->assertTrue($collection->containsPairing(['bar', 'foo']));

        $this->assertFalse($collection->containsPairing(['foo', 'foo']));
        $this->assertFalse($collection->containsPairing(['bar', 'bar']));
        $this->assertFalse($collection->containsPairing(['baz', 'qux']));
    }

    public function testWithoutpairingReturnsANewCollectionContainingPairingsThatDoNotContainTheSpecifiedPairing()
    {
        $collection = new PairingsCollection([
            new Pairings([['foo', 'bar'], ['baz', 'qux']]),
            new Pairings([['foo', 'baz'], ['bar', 'qux']]),
            new Pairings([['foo', 'qux'], ['bar', 'baz']]),
        ]);

        $something = $collection->withoutPairing(['foo', 'bar']);

        $this->assertNotSame($collection, $something);

        $this->assertEquals(new PairingsCollection([
            new Pairings([['foo', 'baz'], ['bar', 'qux']]),
            new Pairings([['foo', 'qux'], ['bar', 'baz']]),
        ]), $something);
    }
}
