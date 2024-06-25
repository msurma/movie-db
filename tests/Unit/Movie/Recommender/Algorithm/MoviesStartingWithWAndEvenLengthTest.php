<?php

namespace App\Tests\Unit\Movie\Recommender\Algorithm;

use App\Movie\Recommender\Algorithm\MoviesStartingWithWAndEvenLength;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MoviesStartingWithWAndEvenLengthTest extends TestCase
{
    protected MoviesStartingWithWAndEvenLength $algorithm;

    public function setUp(): void
    {
        $this->algorithm = new MoviesStartingWithWAndEvenLength();
    }

    public function testGetAlgorithmNameMatchesNameConstant()
    {
        $this->assertSame(MoviesStartingWithWAndEvenLength::getAlgorithmName(), MoviesStartingWithWAndEvenLength::NAME);
    }

    #[DataProvider('provideMovieData')]
    public function testGetRecommendations(array $movieData, array $expectedRecommendations): void
    {
         $this->assertEquals(
            $expectedRecommendations,
            $this->algorithm->getRecommendations($movieData)
        );
    }

    /**
     * @return \Generator
     */
    public static function provideMovieData(): \Generator
    {
        yield 'returns empty array when an empty movie list provided' => [
            [],
            [],
        ];

        yield 'returns movies starting with W and even length, preserving original order' => [
            [
                'Whiplash',
                'Wyspa tajemnic',
                'Władca Pierścieni: Drużyna Pierścienia',
            ],
            [
                'Whiplash',
                'Wyspa tajemnic',
                'Władca Pierścieni: Drużyna Pierścienia',
            ],
        ];

        yield 'ignores movies that do not start with W' => [
            [
                'Django',
                'Whiplash',
            ],
            [
                'Whiplash',
            ],
        ];

        yield 'ignores movies with odd length' => [
            [
                'Wielki Gatsby',
                'Whiplash',
            ],
            [
                'Whiplash',
            ],
        ];

        yield 'filters out movies not starting with W or odd length' => [
            [
                'Django',
                'Whiplash',
                'Wyspa tajemnic',
                'Wielki Gatsby',
                'Władca Pierścieni: Drużyna Pierścienia',
            ],
            [
                'Whiplash',
                'Wyspa tajemnic',
                'Władca Pierścieni: Drużyna Pierścienia',
            ],
        ];

        yield 'case insensitive checks' => [
            [
                'Whiplash',
                'wyspa tajemnic',
            ],
            [
                'Whiplash',
                'wyspa tajemnic',
            ],
        ];

        yield 'handles unicode inputs' => [
            [
                'Władca', // strlen() == 7, mb_strlen() == 6
                'Władcaa', // strlen() == 8, mb_strlen() == 7
                'Władca pierścieni', // strlen() == 19, mb_strlen() == 17
                'Władca pierścienią', // strlen() == 21, mb_strlen() == 18
            ],
            [
                'Władca',
                'Władca pierścienią',
            ],
        ];

        yield 'handles non-string and unusual string scenarios' => [
            [
                null,
                false,
                true,
                1,
                1.5,
                ['foo', 'bar'],
                (new \stdClass()),
                new class {
                    public function __toString()
                    {
                        return 'xyz';
                    }
                },
            ],
            [],
        ];
    }
}