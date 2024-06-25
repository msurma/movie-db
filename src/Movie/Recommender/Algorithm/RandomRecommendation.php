<?php

namespace App\Movie\Recommender\Algorithm;

use App\Utils\Randomizer;

/**
 * Class RandomRecommendation
 *
 * Returns X random movies from provided array
 */
final class RandomRecommendation implements AlgorithmInterface
{
    public const NAME = 'randomRecommendation';

    public const MOVIE_LIMIT = 3;

    public function __construct(
        private readonly Randomizer $randomizer,
    ) {
    }

    public static function getAlgorithmName(): string
    {
        return self::NAME;
    }

    public function getRecommendations(array $movies): array
    {
        $moviesFiltered = array_filter($movies, static fn($value) => is_string($value));
        $keys = $this->randomizer->pickArrayKeys($moviesFiltered, self::MOVIE_LIMIT);

        return array_values(
            array_map(
                static fn($key) => $moviesFiltered[$key],
                $keys
            )
        );
    }
}