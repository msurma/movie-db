<?php

namespace App\Utils;

/**
 * Class Randomizer
 *
 * This class acts as a wrapper for the final class \Random\Randomizer
 * for easier testing and mocking.
 */
class Randomizer
{
    public function __construct(
        private readonly \Random\Randomizer $baseRandomizer,
    )
    {
    }

    /**
     * @see \Random\Randomizer::pickArrayKeys()
     */
    public function pickArrayKeys(array $array, int $num)
    {
        return $this->baseRandomizer->pickArrayKeys($array, $num);
    }
}