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
class PairPicker
{
    /**
     * Throws an exception if the specified array of people is invalid in some way, or returns TRUE otherwise.
     * 
     * @param array $people
     * @return boolean
     * @throw \InvalidArgumentException If there are insufficient people.
     * @throw \InvalidArgumentException If a person appears more than once.
     */
    private function assertPeopleValid(array $people)
    {
        if (count($people) < 2) {
            throw new \InvalidArgumentException('There are insufficient people.');
        }

        if (count(array_unique($people)) !== count($people)) {
            throw new \InvalidArgumentException('A person appears more than once.');
        }

        return true;
    }

    /**
     * @param array $people
     * @return array
     */
    private function createEvenNumberOfPeople(array $people)
    {
        if (count($people) % 2 === 0) {
            return $people;
        }

        return array_merge($people, [null]);
    }

    private function peopleCreateNewWithoutPersonAtIndex(array $people, $i)
    {
        array_splice($people, $i, 1);
        return $people;
    }

    //@todo Rename this.
    private function beenTogetherBefore(array $pairingsHistory, array $pair)
    {
        foreach ($pairingsHistory as $oldPairings) {
            if ($oldPairings->contains($pair)) {
                return true;
            }
        }

        return false;
    }

    private function completePairings(Pairings $accumulatedPairings, array $unpairedPeople, array &$pairingsHistory)
    {
        if (empty($unpairedPeople)) {
            $pairingsHistory[] = $accumulatedPairings;
            return true;
        }

        $rootPerson = array_shift($unpairedPeople);

        foreach ($unpairedPeople as $otherPersonIdx => $otherPerson) {
            if ($this->beenTogetherBefore($pairingsHistory, [$rootPerson, $otherPerson])) {
                continue;
            }

            $extendedPairings = $accumulatedPairings
                ->copy()
                ->add([$rootPerson, $otherPerson])
            ;

            $remainingUnpairedPeople = $this->peopleCreateNewWithoutPersonAtIndex($unpairedPeople, $otherPersonIdx);

            //If this branch - think back to the root in `createUniqueCombinations()` - yielded a unique combination
            //then we're done.  Otherwise we'll try something different in the next iteration.
            if ($this->completePairings($extendedPairings, $remainingUnpairedPeople, $pairingsHistory)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Repeatedly rearranges the specified people into pairs, returning all the unique combinations of pairings.
     * 
     * @param array $people
     * @return Danbettles\PairPicker\Pairings[]
     */
    public function createUniqueCombinations(array $people)
    {
        $this->assertPeopleValid($people);

        $unpairedPeople = $this->createEvenNumberOfPeople($people);

        $rootPerson = array_shift($unpairedPeople);

        $uniqueCombinations = [];

        foreach ($unpairedPeople as $otherPersonIdx => $otherPerson) {
            //(At this level, there's no need to check if the pair have been together before.)
            $currentPairings = new Pairings([[$rootPerson, $otherPerson]]);

            $remainingUnpairedPeople = $this->peopleCreateNewWithoutPersonAtIndex($unpairedPeople, $otherPersonIdx);

            $this->completePairings($currentPairings, $remainingUnpairedPeople, $uniqueCombinations);
        }

        return $uniqueCombinations;
    }
}
