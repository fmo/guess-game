<?php

namespace Guess\Domain\League;

class League
{
    private int $id;
    private string $name;
    private string $leagueNameSlugged;
    private string $logo;
    private int $leagueApiId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLeagueNameSlugged(): string
    {
        return $this->leagueNameSlugged;
    }

    public function setLeagueNameSlugged(string $leagueNameSlugged): self
    {
        $this->leagueNameSlugged = $leagueNameSlugged;

        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLeagueApiId(): int
    {
        return $this->leagueApiId;
    }

    public function setLeagueApiId(int $leagueApiId): self
    {
        $this->leagueApiId = $leagueApiId;

        return $this;
    }


}
