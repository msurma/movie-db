<?php

namespace App\Movie\Recommender\Algorithm;

use \Random\Randomizer;

/**
 * Returns X random movies from provided array
 */
final class RandomRecommendation implements AlgorithmInterface
{
    public const NAME = 'randomRecommendation';

    private const MOVIE_LIMIT = 3;

    public function __construct(
        private Randomizer $randomizer,
    )
    {
    }

    public static function getAlgorithmName(): string
    {
        return self::NAME;
    }

    public function getRecommendations(array $movies): array
    {
        $keys = $this->randomizer->pickArrayKeys($movies, self::MOVIE_LIMIT);

        return array_map(
            static fn ($key) => $movies[$key],
            $keys
        );
    }
}