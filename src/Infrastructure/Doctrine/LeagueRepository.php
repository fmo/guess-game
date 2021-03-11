<?php

namespace Guess\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Guess\Domain\League\League;
use Guess\Domain\League\LeagueRepositoryInterface;

class LeagueRepository extends ServiceEntityRepository implements LeagueRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, League::class);
    }

    /**
     * @param League $league
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(League $league)
    {
        $this->_em->persist($league);
        $this->_em->flush();
    }
}
