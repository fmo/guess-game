<?php

namespace Guess\Application\Handler\League;

use Guess\Domain\League\LeagueRepositoryInterface;

class ListLeagueHandler
{
    private LeagueRepositoryInterface $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->leagueRepository->findAll();
    }
}
