<?php

namespace ServiceJF\ChallengeDLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GamePhase
 *
 * @ORM\Table(name="dlGamePhase")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeDLBundle\Repository\GamePhaseRepository")
 */
class GamePhase
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
     * @var bool
     *
     * @ORM\Column(name="validBet", type="boolean", nullable=true)
     */
    private $validBet;

    /**
     * @var bool
     *
     * @ORM\Column(name="curatedBet", type="boolean", nullable=true)
     */
    private $curatedBet;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @ORM\OneToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $better;

    /**
     * @ORM\OneToOne(targetEntity="ServiceJF\ChallengeDLBundle\Entity\SetBet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $setBet;

    /**
     * @ORM\OneToMany(targetEntity="ServiceJF\ChallengeDLBundle\Entity\ValidBet", mappedBy="gamePhase")
     */
    private $bets;

    /**
     * @return mixed
     */
    public function getBets()
    {
        return $this->bets;
    }

    /**
     * @param mixed $bets
     */
    public function setBets($bets)
    {
        $this->bets = $bets;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set validBet
     *
     * @param boolean $validBet
     *
     * @return GamePhase
     */
    public function setValidBet($validBet)
    {
        $this->validBet = $validBet;

        return $this;
    }

    /**
     * Get validBet
     *
     * @return bool
     */
    public function getValidBet()
    {
        return $this->validBet;
    }

    /**
     * Set curatedBet
     *
     * @param boolean $curatedBet
     *
     * @return GamePhase
     */
    public function setCuratedBet($curatedBet)
    {
        $this->curatedBet = $curatedBet;

        return $this;
    }

    /**
     * Get curatedBet
     *
     * @return bool
     */
    public function getCuratedBet()
    {
        return $this->curatedBet;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return GamePhase
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return mixed
     */
    public function getBetter()
    {
        return $this->better;
    }

    /**
     * @return mixed
     */
    public function getSetBet()
    {
        return $this->setBet;
    }

    /**
     * @param mixed $setBet
     */
    public function setSetBet($setBet)
    {
        $this->setBet = $setBet;
    }

    /**
     * @param mixed $better
     */
    public function setBetter($better)
    {
        $this->better = $better;
    }


}

