<?php

namespace App\Movie\Recommender;

use App\Movie\Recommender\Algorithm\AlgorithmInterface;
use App\Movie\Recommender\Exception\UnknownRecommendationAlgorithm;

final class RecommenderService implements RecommenderInterface
{
    public function __construct(
        /** @var AlgorithmInterface[] */
        private iterable $algorithms,
    )
    {
        $this->algorithms = $algorithms instanceof \Traversable ? iterator_to_array($algorithms) : $algorithms;
    }

    /**
     * @inheritDoc
     */
    public function getAlgorithms(): array
    {
        return array_keys($this->algorithms);
    }

    /**
     * @inheritDoc
     */
    public function getRecommendations(array $movies, string $algorithm): array
    {
        if (!array_key_exists($algorithm, $this->algorithms)) {
            throw new UnknownRecommendationAlgorithm(
                sprintf('Unknown recommendation algorithm: [%s]', $algorithm)
            );
        }

        return $this->algorithms[$algorithm]->getRecommendations($movies);
    }
}