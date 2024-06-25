<?php

namespace App\Movie\Recommender\Command;

use App\Movie\Recommender\RecommenderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

#[AsCommand(
    name: 'app:movie:recommender',
    description: 'Recommend movies from movies.php database',
)]
final class RecommenderCommand extends Command
{
    public function __construct(
        private RecommenderInterface $recommender,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $questionHelper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            'Select recommendation algorithm',
            $this->recommender->getAlgorithms()
        );

        $algorithm = $questionHelper->ask($input, $output, $question);

        $movies = require 'movies.php';

        $recommendations = $this->recommender->getRecommendations($movies, $algorithm);
        $output->writeln($recommendations);

        return Command::SUCCESS;
    }
}