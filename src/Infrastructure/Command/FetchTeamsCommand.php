<?php

namespace Guess\Infrastructure\Command;

use Exception;
use Guess\Application\Handler\League\ListLeagueHandler;
use Guess\Application\Handler\Team\CreateTeamHandler;
use Guess\Domain\League\League;
use Guess\Infrastructure\Services\FetchTeamsInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchTeamsCommand extends Command
{
    protected static $defaultName = 'app:fetch-teams';
    private CreateTeamHandler $createTeamHandler;
    private FetchTeamsInterface $fetcherService;
    private ListLeagueHandler $listLeagueHandler;

    public function __construct(
        CreateTeamHandler $createGameHandler,
        FetchTeamsInterface $fetcherService,
        ListLeagueHandler $listLeagueHandler
    )
    {
        $this->createTeamHandler = $createGameHandler;
        $this->fetcherService = $fetcherService;
        $this->listLeagueHandler = $listLeagueHandler;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $leagues = $this->listLeagueHandler->handle();

        if (!$leagues) {
            $output->writeln("There are no leagues to add teams");
            return Command::FAILURE;
        }

        /** @var League $league */
        foreach ($leagues as $league) {
            if (!$league->getLeagueApiId()) {
                $output->writeln("We need to know rapid api league id");
            }

            $teams = $this->fetcherService->fetch(
                [
                    'league-api-id' => $league->getLeagueApiId()
                ]
            );

            foreach ($teams as $team) {
                try {
                    $this->createTeamHandler->handle($team);
                } catch (Exception $e) {
                    $output->writeln($e->getMessage());
                }
            }
        }

        $output->writeln('Teams are created');

        return Command::SUCCESS;
    }
}
