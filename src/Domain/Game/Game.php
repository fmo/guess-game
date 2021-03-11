<?php

namespace Guess\Domain\Game;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Guess\Domain\League\League;
use Guess\Domain\Player\Guess;
use Guess\Domain\Team\Team;

class Game
{
    private int $id;
    private string $score;
    private Team $homeTeam;
    private Team $awayTeam;
    private DateTimeInterface $gameTime;
    private ArrayCollection $guesses;
    private League $league;

    public function __construct()
    {
        $this->guesses = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getScore(): string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(Team $homeTeam): self
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(Team $awayTeam): self
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    public function getGameTime(): DateTimeInterface
    {
        return $this->gameTime;
    }

    public function setGameTime(DateTimeInterface $gameTime): self
    {
        $this->gameTime = $gameTime;

        return $this;
    }

    public function getGuesses(): ArrayCollection
    {
        return $this->guesses;
    }

    public function setGuesses(ArrayCollection $guesses): self
    {
        $this->guesses = $guesses;

        return $this;
    }

    public function getLeague(): League
    {
        return $this->league;
    }

    public function setLeague(League $league): self
    {
        $this->league = $league;

        return $this;
    }

    /**
     * @param string $score
     * @throws Exception
     */
    public function completed(string $score)
    {
        if (new DateTimeImmutable() < $this->getGameTime()) {
            throw new Exception('This game has not started yet');
        }

        $this->setScore($score);

        /** @var Guess $guess */
        foreach ($this->guesses as $guess) {
            if ($guess->getGuess() == $score) {
                $guess->getPlayer()->pointUp();
            }
        }
    }

    public function addGuess(Guess $guess) {
        $this->guesses->add($guess);
    }
}
