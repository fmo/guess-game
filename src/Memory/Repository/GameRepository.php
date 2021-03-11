<?php

namespace Guess\Memory\Repository;

use Guess\Domain\Game\Game;
use Guess\Domain\Game\GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface
{
    private array $games;

    public function __construct()
    {
        $this->games = [];
    }

    /**
     * @param int $id
     * @return Game|null
     */
    public function findOneById(int $id): ?Game
    {
        foreach ($this->games as $game) {
            if ($game->getId() === $id) {
                return $game;
            }
        }

        return null;
    }

    public function findGamesForGivenWeek(): array
    {
        return $this->getGames();
    }

    public function findOneBy(array $criteria): ?Game
    {
        /** @var Game $game */
        foreach ($this->games as $game) {
            if ($game->getHomeTeam() == $criteria['homeTeam'] &&
                $game->getAwayTeam() == $criteria['awayTeam'] &&
                $game->getGameTime()->getTimestamp() == $criteria['gameTime']->getTimestamp()
            ) {
                return $game;
            }
        }

        return null;
    }

    public function save(Game $game)
    {
        $this->games[] = $game;
    }

    public function getGames(): array
    {
        return $this->games;
    }
}
