<?php

namespace Guess\Application\Handler\Team;

use Exception;
use Guess\Application\Services\FileUploaderInterface;
use Guess\Domain\Team\Team;
use Guess\Domain\Team\TeamRepositoryInterface;

class CreateTeamHandler
{
    private TeamRepositoryInterface $teamRepository;
    private FileUploaderInterface $logoUploader;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        FileUploaderInterface $logoUploader
    )
    {
        $this->teamRepository = $teamRepository;
        $this->logoUploader = $logoUploader;
    }

    /**
     * @param array $team
     * @throws Exception
     */
    public function handle(array $team): void
    {
        if ($this->teamRepository->findOneBy(['name' => $team['name']])) {
            throw new Exception('Team already saved');
        }

        if (!isset($team['logo'])) {
            throw new Exception('We need team logo to save the team');
        }

        try {
            $this->logoUploader->upload('guess-team-logos', $team['name'], $team['logo']);
        } catch (Exception $exception) {
            throw new Exception("Cant upload the logo: ".$exception);
        }

        $this->teamRepository->save(
            (new Team())
                ->setName($team['name'])
                ->setLogo($this->logoUploader->getImageUrl())
        );
    }
}
