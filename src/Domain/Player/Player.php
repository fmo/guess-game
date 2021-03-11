<?php

namespace Guess\Domain\Player;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Guess\Domain\Game\Game;
use Symfony\Component\Security\Core\User\UserInterface;

class Player implements UserInterface
{
    const RIGHT_GUESS_POINT = 3;

    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private DateTimeInterface $createdAt;
    private int $point;
    private int $avatar;
    private bool $isActive;
    private Collection $guesses;

    public function __construct()
    {
        $this->avatar = 1;
        $this->point = 0;
        $this->createdAt = new DateTimeImmutable();
        $this->isActive = true;
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPoint(): int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getAvatar(): int
    {
        return $this->avatar;
    }

    public function setAvatar(int $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @param Game $game
     * @param int $homeTeamGuess
     * @param int $awayTeamGuess
     * @throws Exception
     */
    public function makeGuesses(Game $game, int $homeTeamGuess, int $awayTeamGuess)
    {
        if ((new DateTimeImmutable()) > $game->getGameTime()) {
            throw new Exception("Starting time passed for this game, cant make a guess");
        }

        $guess = new Guess();
        $guess->setPlayer($this);
        $guess->setGame($game);
        $guess->setCreatedAt(new DateTimeImmutable());
        $guess->setGuess($homeTeamGuess.'-'.$awayTeamGuess);

        $this->guesses->add($guess);
        $game->addGuess($guess);
    }

    public function pointUp(): void
    {
        $this->point += self::RIGHT_GUESS_POINT;
    }
}
