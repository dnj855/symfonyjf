<?php

namespace ServiceJF\ChallengeCM18Bundle\Repository;

use ServiceJF\ChallengeCM18Bundle\Entity\Pool;

/**
 * TeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamRepository extends \Doctrine\ORM\EntityRepository
{
    public function findRankingByPool(Pool $pool)
    {
        return $this->createQueryBuilder('t')
            ->where('t.pool = :pool')
            ->setParameters(array(
                'pool' => $pool
            ))
            ->addOrderBy('t.points', 'DESC')
            ->addOrderBy('t.goalAverage', 'DESC')
            ->addOrderBy('t.goalsFor', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
