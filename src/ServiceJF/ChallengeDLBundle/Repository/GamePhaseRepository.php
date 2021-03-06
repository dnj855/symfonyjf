<?php

namespace ServiceJF\ChallengeDLBundle\Repository;

/**
 * GamePhaseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GamePhaseRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNonCuratedBets()
    {
        $qb = $this->createQueryBuilder('g');

        return $qb
            ->where($qb->expr()->andX(
                $qb->expr()->isNull('g.curatedBet'),
                $qb->expr()->eq('g.validBet', "1")
            ))
            ->getQuery()
            ->getResult();
    }

    public function getRanking()
    {
        $qb = $this->createQueryBuilder('g');
        return $qb
            ->where($qb->expr()->isNotNull('g.curatedBet'))
            ->orderBy('g.points', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    public function findAllValidBets()
    {
        return $this->createQueryBuilder('g')
            ->where('g.curatedBet = 1')
            ->getQuery()
            ->getResult();
    }
}
