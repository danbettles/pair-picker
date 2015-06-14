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
class Pairings
{
    private $array;

    public function __construct(array $pairingsArray = [])
    {
        $this->replaceArray($pairingsArray);
    }

    public function add(array $pairing)
    {
        $this->array[] = $pairing;
        return $this;
    }

    private function replaceArray(array $pairingsArray)
    {
        $this->array = [];

        foreach ($pairingsArray as $pairing) {
            $this->add($pairing);
        }

        return $this;
    }

    public function getArray()
    {
        return $this->array;
    }

    public function contains(array $pairing)
    {
        $reversedPairing = [end($pairing), reset($pairing)];

        foreach ($this->getArray() as $currPairing) {
            if ($pairing == $currPairing || $reversedPairing == $currPairing) {
                return true;
            }
        }

        return false;
    }

    public function copy()
    {
        return new self($this->getArray());
    }
}
