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
        $this->setArray($pairingsArray);
    }

    private function setArray(array $pairingsArray)
    {
        $this->array = $pairingsArray;
        return $this;
    }

    public function getArray()
    {
        return $this->array;
    }

    public function contains(array $pairing)
    {
        foreach ($this->getArray() as $currPairing) {
            if ($pairing == $currPairing || $pairing == array_reverse($currPairing)) {
                return true;
            }
        }

        return false;
    }

    public function add(array $pair)
    {
        $array = $this->getArray();
        $array[] = $pair;
        return $this->setArray($array);
    }

    public function copy()
    {
        return new self($this->getArray());
    }
}
