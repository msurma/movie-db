<?php

namespace App\Movie\Recommender\Algorithm;

/**
 * Class MoviesStartingWithWAndEvenLength
 *
 * Returns movies whose titles start with the letter 'W' and have an even
 * number of characters in the title.
 */
final class MoviesStartingWithWAndEvenLength implements AlgorithmInterface
{
    public const NAME = 'movieStartingWithWAndEvenLength';

    public static function getAlgorithmName(): string
    {
        return self::NAME;
    }

    public function getRecommendations(array $movies): array
    {
        return array_values(
            array_filter($movies, function ($movie) {
                return
                    is_string($movie) &&
                    stripos($movie, 'W') === 0 &&
                    mb_strlen($movie) % 2 == 0;
            })
        );
    }
}