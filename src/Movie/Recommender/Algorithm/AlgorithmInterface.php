<?php

namespace App\Movie\Recommender\Algorithm;

interface AlgorithmInterface
{
    public static function getAlgorithmName(): string;

    /**
     * @param array<string> $movies
     * @return array<string>
     */
    public function getRecommendations(array $movies): array;
}