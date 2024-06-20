<?php

namespace App\Movie\Recommender\Algorithm;

/**
 * Returns movies whose titles contains more than one word
 */
final class MoviesWithMoreThanOneWord implements AlgorithmInterface
{
    public const NAME = 'moviesWithMoreThanOneWord';

    public static function getAlgorithmName(): string
    {
        return self::NAME;
    }

    public function getRecommendations(array $movies): array
    {
        return array_filter($movies, function($movie) {
            return str_contains(trim($movie), ' ');
        });
    }
}