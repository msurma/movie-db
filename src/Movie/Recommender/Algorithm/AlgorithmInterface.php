<?php

namespace App\Movie\Recommender\Algorithm;

interface AlgorithmInterface
{
    public static function getAlgorithmName(): string;

    public function getRecommendations(array $movies): array;
}