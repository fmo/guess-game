<?php

namespace Guess\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Guess\Application\Filter\Game\FilterByLeagueNameSluggedTrait;
use Guess\Domain\Game\GameRepositoryInterface;
use Guess\Domain\League\League;
use Guess\Domain\League\LeagueRepositoryInterface;
use Guess\Infrastructure\Doctrine\GameRepository;

class ListGameHandler
{
    use FilterByLeagueNameSluggedTrait;

    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private LeagueRepositoryInterface $leagueRepository
    )
    {
    }

    /**
     * @param string $week
     * @param string $leagueNameSlugged
     * @return array
     * @throws Exception
     */
    public function handle(string $week, string $leagueNameSlugged): array
    {
        /** @var League $league */
        $league = $this->leagueRepository->findOneBy([
            'leagueNameSlugged' => $leagueNameSlugged
        ]);

        if (!$league) {
            throw new Exception('Which league matches you want to see?');
        }

        $gamesForGivenWeek = $this->gameRepository->findGamesForGivenWeek(
            new DateTimeImmutable(
                $week ? $week." week" : "now"
            )
        );

        return $this->filter($gamesForGivenWeek, $league->getLeagueNameSlugged());
    }
}
