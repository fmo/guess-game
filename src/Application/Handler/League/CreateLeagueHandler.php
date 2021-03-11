<?php

namespace Guess\Application\Handler\League;

use Exception;
use Guess\Application\Services\FileUploaderInterface;
use Guess\Domain\League\League;
use Guess\Domain\League\LeagueRepositoryInterface;

class CreateLeagueHandler
{
    private LeagueRepositoryInterface $leagueRepository;
    private FileUploaderInterface $logoUploader;

    public function __construct(
        LeagueRepositoryInterface $leagueRepository,
        FileUploaderInterface $logoUploader)
    {
        $this->leagueRepository = $leagueRepository;
        $this->logoUploader = $logoUploader;
    }

    /**
     * @param array $league
     * @throws Exception
     */
    public function handle(array $league): void
    {
        if ($this->leagueRepository->findOneBy(['name' => $league['name']])) {
            throw new Exception('League already saved');
        }

        if (!isset($league['logo'])) {
            throw new Exception('We need team logo to save the team');
        }

        try {
            $this->logoUploader->upload('guess-league-logos', $league['name'], $league['logo']);
        } catch (Exception $exception) {
            throw new Exception("Cant upload the logo: ".$exception);
        }

        $this->leagueRepository->save(
            (new League())
                ->setName($league['name'])
                ->setLogo($this->logoUploader->getImageUrl())
                ->setLeagueApiId($league['leagueApiId'])
                ->setLeagueNameSlugged($league['leagueNameSlugged'])
        );
    }
}
