<?php

namespace ServiceJF\ChallengeCM18Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pool
 *
 * @ORM\Table(name="cm18Pool")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCM18Bundle\Repository\PoolRepository")
 */
class Pool
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pool", type="string", length=1, unique=true)
     */
    private $pool;

    /**
     * @ORM\OneToMany(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Team", mappedBy="pool")
     */
    private $teams;

    /**
     * @return mixed
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pool.
     *
     * @param string $pool
     *
     * @return Pool
     */
    public function setPool($pool)
    {
        $this->pool = $pool;

        return $this;
    }

    /**
     * Get pool.
     *
     * @return string
     */
    public function getPool()
    {
        return $this->pool;
    }

    public function getDisplayName()
    {
        return 'Groupe ' . $this->pool;
    }
}
