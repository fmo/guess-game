<?php

namespace Guess\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Guess\Domain\Team\Team;
use Guess\Domain\Team\TeamRepositoryInterface;

class TeamRepository extends ServiceEntityRepository implements TeamRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * @param Team $match
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Team $match)
    {
        $this->_em->persist($match);
        $this->_em->flush();
    }
}
