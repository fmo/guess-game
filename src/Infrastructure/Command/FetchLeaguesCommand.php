<?php

namespace Guess\Infrastructure\Command;

use Exception;
use Guess\Application\Handler\League\CreateLeagueHandler;
use Guess\Infrastructure\Services\FetchLeaguesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchLeaguesCommand extends Command
{
    protected static $defaultName = 'app:fetch-leagues';
    private CreateLeagueHandler $createLeagueHandler;
    private FetchLeaguesInterface $fetcherService;

    public function __construct(
        CreateLeagueHandler $createLeagueHandler,
        FetchLeaguesInterface $fetcherService,
        string $name = null,
    )
    {
        $this->createLeagueHandler = $createLeagueHandler;
        $this->fetcherService = $fetcherService;
        parent::__construct($name);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $leagues = $this->fetcherService->fetch([]);

        foreach ($leagues as $league) {
            try {
                $this->createLeagueHandler->handle($league);
                $output->writeln($league['name']." saved");
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        $output->writeln('Leagues are created');

        return Command::SUCCESS;
    }
}
