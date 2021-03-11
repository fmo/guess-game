<?php

namespace Guess\Memory\Repository;

use Guess\Domain\Team\Team;
use Guess\Domain\Team\TeamRepositoryInterface;


class TeamRepository implements TeamRepositoryInterface
{
    private array $teams;

    public function __construct()
    {
        $this->teams = [];
    }

    public function findOneBy(array $criteria): ?Team
    {
        foreach ($this->teams as $team) {
            if ($team->getName() == $criteria['name']) {
                return $team;
            }
        }

        return null;
    }

    public function getAll(): array
    {
        return $this->teams;
    }

    public function save(Team $team)
    {
        $this->teams[] = $team;
    }
}
