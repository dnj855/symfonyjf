<?php

namespace ServiceJF\ChallengeDLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ValidBet
 *
 * @ORM\Table(name="dlValidBet")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeDLBundle\Repository\ValidBetRepository")
 */
class ValidBet
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
     * @ORM\Column(name="joker", type="boolean")
     */
    private $joker;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeDLBundle\Entity\GamePhase", inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gamePhase;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeDLBundle\Entity\Personality")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personality;

    public function __construct($gamePhase)
    {
        $this->gamePhase = $gamePhase;
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
     * Set joker
     *
     * @param boolean $joker
     *
     * @return ValidBet
     */
    public function setJoker($joker)
    {
        $this->joker = $joker;

        return $this;
    }

    /**
     * Get joker
     *
     * @return bool
     */
    public function getJoker()
    {
        return $this->joker;
    }

    /**
     * @return mixed
     */
    public function getGamePhase()
    {
        return $this->gamePhase;
    }

    /**
     * @param mixed $better
     */
    public function setGamePhase($gamePhase)
    {
        $this->gamePhase = $gamePhase;
    }

    /**
     * @return mixed
     */
    public function getPersonality()
    {
        return $this->personality;
    }

    /**
     * @param mixed $personality
     */
    public function setPersonality($personality)
    {
        $this->personality = $personality;
    }


}

