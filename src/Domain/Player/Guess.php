<?php

namespace Guess\Domain\Player;

use Guess\Domain\Game\Game;
use DateTimeInterface;
use Guess\Domain\Player\Player;

class Guess
{
    private int $id;
    private string $guess;
    private DateTimeInterface $createdAt;
    private Game $game;
    private Player $player;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getGuess(): string
    {
        return $this->guess;
    }

    public function setGuess(string $guess): self
    {
        $this->guess = $guess;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }

}
