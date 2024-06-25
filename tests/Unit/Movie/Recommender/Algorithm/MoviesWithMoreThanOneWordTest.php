<?php

namespace App\Tests\Unit\Movie\Recommender\Algorithm;

use App\Movie\Recommender\Algorithm\MoviesWithMoreThanOneWord;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MoviesWithMoreThanOneWordTest extends TestCase
{
    protected MoviesWithMoreThanOneWord $algorithm;

    public function setUp(): void
    {
        $this->algorithm = new MoviesWithMoreThanOneWord();
    }

    public function testGetAlgorithmNameMatchesNameConstant()
    {
        $this->assertSame(MoviesWithMoreThanOneWord::getAlgorithmName(), MoviesWithMoreThanOneWord::NAME);
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
        yield 'returns movies with more than 1 word, preserving original order' => [
            [
                'Ojciec chrzestny',
                'Leon zawodowiec',
                'Dwunastu gniewnych ludzi',
            ],
            [
                'Ojciec chrzestny',
                'Leon zawodowiec',
                'Dwunastu gniewnych ludzi',
            ],
        ];

        yield 'filters single worded titles' => [
            [
                'Incepcja',
                'Forrest Gump',
            ],
            [
                'Forrest Gump',
            ],
        ];

        yield 'ignores whitespaces at the end and beginning of movie title' => [
            [
                " Incepcja\n",
                ' Forrest Gump',
                ' Pianista',
                "Władca Pierścieni:\n Powrót króla\n",
            ],
            [
                ' Forrest Gump',
                "Władca Pierścieni:\n Powrót króla\n",
            ],
        ];

        yield 'ignores titles with only whitespace characters' => [
            [
                '   ',
                "\t",
                "\n",
            ],
            [],
        ];

        yield 'case insensitive check' => [
            [
                'the matrix',
                'The Matrix',
                'tHe MaTriX'
            ],
            [
                'the matrix',
                'The Matrix',
                'tHe MaTriX'
            ],
        ];

        yield 'returns empty array when an empty movie list provided' => [
            [],
            [],
        ];

        yield 'returns empty array with a single word titles list provided' => [
            [
                'Incepcja',
                'Zjawa',
            ],
            [],
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
