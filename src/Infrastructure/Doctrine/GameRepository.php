<?php

namespace Guess\Infrastructure\Doctrine;

use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Guess\Domain\Game\Game;
use Guess\Domain\Game\GameRepositoryInterface;
use Guess\Infrastructure\Doctrine\DateHelpers\DateTrait;

class GameRepository extends ServiceEntityRepository implements GameRepositoryInterface
{
    use DateTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findGamesForGivenWeek(DateTimeImmutable $gameTime): array
    {
        $qb = $this->createQueryBuilder("g");
        $qb->andWhere("g.gameTime BETWEEN :from AND :to")
            ->setParameter('from', $this->startingDayOfGivenWeek($gameTime))
            ->setParameter('to', $this->endingDayOfGivenWeek($gameTime));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Game $game
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Game $game)
    {
        $this->_em->persist($game);
        $this->_em->flush();
    }
}
