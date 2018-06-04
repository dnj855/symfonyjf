<?php

namespace ServiceJF\ChallengeCM18Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ServiceJF\UserBundle\Entity\User;

/**
 * Player
 *
 * @ORM\Table(name="cm18Player")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCM18Bundle\Repository\PlayerRepository")
 */
class Player
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
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Team")
     * @ORM\JoinColumn(nullable=true)
     */
    private $finalBet;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $identity;

    /**
     * @var int
     *
     * @ORM\Column(name="perfect", type="integer")
     */
    private $perfect;

    /**
     * @return mixed
     */
    public function getFinalBet()
    {
        return $this->finalBet;
    }

    /**
     * @return int
     */
    public function getPerfect()
    {
        return $this->perfect;
    }

    /**
     * @param int $perfect
     */
    public function setPerfect($perfect)
    {
        $this->perfect = $perfect;
    }

    public function __construct(User $user)
    {
        $this->identity = $user;
        $this->points = 0;
        $this->perfect = 0;
    }

    /**
     * @param mixed $finalBet
     */
    public function setFinalBet($finalBet)
    {
        $this->finalBet = $finalBet;
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param mixed $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
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
     * Set points.
     *
     * @param int $points
     *
     * @return Player
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points.
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }
}
