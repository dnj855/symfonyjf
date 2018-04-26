<?php

namespace ServiceJF\ChallengeFGBundle\Repository;

/**
 * BestPunchlineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BestPunchlineRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByMonth()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.month', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findMostRecent()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.month', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAndOrder()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.month', 'DESC')
            ->getQuery()
            ->getResult();
    }
}