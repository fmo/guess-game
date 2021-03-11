<?php

namespace Guess\Infrastructure\Command;

use Exception;
use Guess\Application\Handler\Game\CreateGameHandler;
use Guess\Infrastructure\Services\FetchGamesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchGamesCommand extends Command
{
    protected static $defaultName = 'app:fetch-games';
    private FetchGamesInterface $fetchGames;
    private CreateGameHandler $createGameHandler;

    public function __construct(
        FetchGamesInterface $fetchGames,
        CreateGameHandler $createGameHandler
    )
    {
        $this->fetchGames = $fetchGames;
        $this->createGameHandler = $createGameHandler;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $games = $this->fetchGames->fetch(
            ['days' => $input->getArgument('days')]
        );

        foreach ($games as $game) {
            try {
                $this->createGameHandler->handle($game);
                $output->writeln($game['homeTeam'].'-'.$game['awayTeam']." games are saved.");
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        $output->writeln('Games are created');

        return Command::SUCCESS;
    }

    protected function configure()
    {
        parent::configure();

        $this->addArgument('days', InputArgument::REQUIRED);
    }
}
