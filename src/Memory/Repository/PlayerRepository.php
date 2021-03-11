<?php

namespace Guess\Memory\Repository;

use Guess\Domain\Player\Player;
use Guess\Domain\Player\PlayerRepositoryInterface;

class PlayerRepository implements PlayerRepositoryInterface
{
    private array $players;

    public function __construct()
    {
        $this->players = [];
    }

    public function save(Player $player)
    {
        $this->players[] = $player;
    }

    /**
     * @param array $criteria
     * @return Player|null
     */
    public function findOneBy(array $criteria): ?Player
    {
        if (isset($criteria['username'])) {
            /** @var Player $player */
            foreach ($this->players as $player) {
                if ($player->getUsername() == $criteria['username']) {
                    return $player;
                }
            }
        }

        if (isset($criteria['id'])) {
            /** @var Player $player */
            foreach ($this->players as $player) {
                if ($player->getId() == $criteria['id']) {
                    return $player;
                }
            }
        }

        return null;
    }

    public function update(Player $player)
    {

    }

    public function getTopPlayers(): array
    {
        usort($this->players, function($player1, $player2) {
            if ($player1->getPoint() == $player2->getPoint()) {
                return 0;
            }
            return ($player1->getPoint() > $player2->getPoint()) ? -1 : 1;
        });

        return $this->players;
    }
}
