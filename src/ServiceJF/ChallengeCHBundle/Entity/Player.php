<?php

namespace ServiceJF\ChallengeCHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ServiceJF\UserBundle\Entity\User;

/**
 * Player
 *
 * @ORM\Table(name="chPlayer")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCHBundle\Repository\PlayerRepository")
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
     * @var int|null
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var int|null
     *
     * @ORM\Column(name="perfects", type="integer")
     */
    private $perfects;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCHBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $finalWinner;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setPerfects(0);
    }

    /**
     * @return mixed
     */
    public function getFinalWinner()
    {
        return $this->finalWinner;
    }

    /**
     * @return int|null
     */
    public function getPerfects()
    {
        return $this->perfects;
    }

    /**
     * @param int|null $perfects
     */
    public function setPerfects($perfects)
    {
        $this->perfects = $perfects;
    }



    /**
     * @param mixed $finalWinner
     */
    public function setFinalWinner($finalWinner)
    {
        $this->finalWinner = $finalWinner;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @param int|null $points
     *
     * @return Player
     */
    public function setPoints($points = null)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points.
     *
     * @return int|null
     */
    public function getPoints()
    {
        return $this->points;
    }
}
