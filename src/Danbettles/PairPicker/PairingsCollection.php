<?php
/**
 * @copyright Copyright (c) 2015, Dan Bettles
 * @license http://www.opensource.org/licenses/MIT MIT
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */

namespace Danbettles\PairPicker;

/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 */
class PairingsCollection
{
    private $manyPairings;

    public function __construct(array $manyPairings = [])
    {
        $this->replaceArray($manyPairings);
    }

    public function add(Pairings $pairings)
    {
        $this->manyPairings[] = $pairings;
        return $this;
    }

    private function replaceArray(array $manyPairings)
    {
        $this->manyPairings = [];

        foreach ($manyPairings as $pairings) {
            $this->add($pairings);
        }

        return $this;
    }

    public function getArray()
    {
        return $this->manyPairings;
    }

    public function containsPairing(array $pairing)
    {
        foreach ($this->getArray() as $pairings) {
            if ($pairings->contains($pairing)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a new collection containing all pairings that do not contain the specified pairing.
     *
     * This returns a new collection because it's a filter method.
     *
     * @param array $pairing
     * @return \self
     */
    public function withoutPairing(array $pairing)
    {
        $newCollection = new self();

        foreach ($this->getArray() as $pairings) {
            if ($pairings->contains($pairing)) {
                continue;
            }

            $newCollection->add($pairings);
        }

        return $newCollection;
    }
}
