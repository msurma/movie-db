<?php

namespace App\Tests\Unit\Movie\Recommender;

use App\Movie\Recommender\Algorithm\AlgorithmInterface;
use App\Movie\Recommender\Exception\UnknownRecommendationAlgorithm;
use App\Movie\Recommender\RecommenderService;
use PHPUnit\Framework\TestCase;

class RecommenderServiceTest extends TestCase
{
    private RecommenderService $service;
    private array $algorithms = [];

    protected function setUp(): void
    {
        $this->algorithms = [
            'algo1' => $this->createMock(AlgorithmInterface::class),
            'algo2' => $this->createMock(AlgorithmInterface::class)
        ];
        $this->service = new RecommenderService($this->algorithms);
    }

    public function testGetAlgorithms()
    {
        $expected = ['algo1', 'algo2'];
        $this->assertEquals($expected, $this->service->getAlgorithms());
    }

    public function testGetRecommendationsWithKnownAlgorithm()
    {
        $movies = ['Movie1', 'Movie2'];
        $recommendations = ['Movie2', 'Movie1'];

        $this->algorithms['algo1']->method('getRecommendations')
            ->with($movies)
            ->willReturn($recommendations);

        $this->assertEquals($recommendations, $this->service->getRecommendations($movies, 'algo1'));
    }

    public function testGetRecommendationsWithUnknownAlgorithm()
    {
        $this->expectException(UnknownRecommendationAlgorithm::class);
        $this->expectExceptionMessage('Unknown recommendation algorithm: [algo3]');

        $this->service->getRecommendations(['Movie1', 'Movie2'], 'algo3');
    }
}