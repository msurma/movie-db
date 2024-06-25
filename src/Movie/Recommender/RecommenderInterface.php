<?php

namespace App\Movie\Recommender;

interface RecommenderInterface
{
    /**
     * Returns recommendation algorithms
     */
    public function getAlgorithms(): array;

    /**
     * Generates recommendations using given algorithm
     */
    public function getRecommendations(array $movies, string $algorithm): array;
}