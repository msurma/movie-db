<?php

namespace App\Tests\Unit\Movie\Recommender\Algorithm;

use App\Movie\Recommender\Algorithm\RandomRecommendation;
use App\Utils\Randomizer;
use PHPUnit\Framework\TestCase;

class RandomRecommendationTest extends TestCase
{
    private Randomizer $randomizer;
    private RandomRecommendation $algorithm;

    protected function setUp(): void
    {
        $this->randomizer = $this->createMock(Randomizer::class);
        $this->algorithm = new RandomRecommendation($this->randomizer);
    }

    public function testGetAlgorithmNameMatchesNameConstant()
    {
        $this->assertSame(RandomRecommendation::getAlgorithmName(), RandomRecommendation::NAME);
    }

    public function testReturnsNoMoviesWhenListIsEmpty(): void
    {
        $movies = [];
        $this->randomizer->method('pickArrayKeys')->willReturn([]);

        $this->assertEquals([], $this->algorithm->getRecommendations($movies));
    }

    public function testReturnsMoviesWhenListIsSmallerThanLimit(): void
    {
        $movies = ['Titanic', 'Matrix'];
        $this->randomizer->method('pickArrayKeys')->willReturn([0, 1]);

        $this->assertEquals(['Titanic', 'Matrix'], $this->algorithm->getRecommendations($movies));
    }

    public function testReturnsLimitMoviesWhenListIsLargerThanLimit(): void
    {
        $movies = ['Titanic', 'Matrix', 'Inception', 'Gladiator'];
        $this->randomizer->method('pickArrayKeys')->willReturn([0, 2, 3]);

        $this->assertEquals(['Titanic', 'Inception', 'Gladiator'], $this->algorithm->getRecommendations($movies));
    }

    public function testHandlesNonStringValues(): void
    {
        $movies = [
            5.4,
            'Titanic',
            null,
            new \stdClass,
            false,
            'Matrix',
            [],
            new class {
                public function __toString()
                {
                    return 'xyz';
                }
            },
            'Inception',
            'Leon zawodowiec',
        ];

        $expectedRandomizerInput = [
            'Titanic',
            'Matrix',
            'Inception',
            'Leon zawodowiec',
        ];

        $this->randomizer->expects($this->once())
            ->method('pickArrayKeys')
            ->with(
                $this->equalToCanonicalizing($expectedRandomizerInput),
                $this->equalTo(RandomRecommendation::MOVIE_LIMIT)
            )
            ->willReturn([1, 5, 9]);

        $this->algorithm->getRecommendations($movies);
    }

    public function testReturnsDifferentMoviesOnDifferentCalls(): void
    {
        $movies = ['Titanic', 'Matrix', 'Inception', 'Gladiator', 'Heat'];
        $this->randomizer->expects($this->exactly(2))->method('pickArrayKeys')
            ->willReturnOnConsecutiveCalls([0, 1, 2], [2, 3, 4]);

        $firstCall = $this->algorithm->getRecommendations($movies);
        $secondCall = $this->algorithm->getRecommendations($movies);

        $this->assertCount(3, $firstCall);
        $this->assertCount(3, $secondCall);
        $this->assertNotEquals($firstCall, $secondCall);
    }
}