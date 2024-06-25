<?php

namespace App\Tests\Integration\Movie\Recommender\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RecommenderCommandTest extends KernelTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
    }

    public function testExecute(): void
    {
        $application = new Application(self::$kernel);

        $command = $application->find('app:movie:recommender');
        $commandTester = new CommandTester($command);

        $commandTester->setInputs(['movieStartingWithWAndEvenLength']);

        $commandTester->execute([0]);

        $commandTester->assertCommandIsSuccessful();

        // assuming that input array is static
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Whiplash
Wyspa tajemnic
Władca Pierścieni: Drużyna Pierścienia', $output);

    }
}