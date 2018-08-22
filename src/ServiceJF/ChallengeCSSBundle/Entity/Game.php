<?php

namespace ServiceJF\ChallengeCSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Game
 *
 * @ORM\Table(name="cssGame")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCSSBundle\Repository\GameRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Game
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
     * @ORM\Column(name="gameNumber", type="integer")
     * @Assert\LessThanOrEqual(38, message="Il y a au maximum 38 journées.")
     * @Assert\GreaterThan(0, message="Merci de saisir des données valides.")
     */
    private $gameNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="result", type="string", length=4, nullable=true)
     */
    private $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", unique=true)
     * @Assert\Date(message="Merci de saisir une date valide.")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $director;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\CoreBundle\Entity\Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCSSBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $opponent;

    /**
     * @var bool
     *
     * @ORM\Column(name="home", type="boolean", nullable=false)
     */
    private $home;

    /**
     * @var int|null
     *
     * @ORM\Column(name="scoreFCMetz", type="integer", nullable=true)
     */
    private $scoreFCMetz;

    /**
     * @var int|null
     *
     * @ORM\Column(name="scoreOpponent", type="integer", nullable=true)
     */
    private $scoreOpponent;

    /**
     * @return mixed
     */
    public function getOpponent()
    {
        return $this->opponent;
    }

    /**
     * @param mixed $opponent
     */
    public function setOpponent($opponent)
    {
        $this->opponent = $opponent;
    }

    /**
     * @return bool
     */
    public function isHome()
    {
        return $this->home;
    }

    /**
     * @param bool $home
     */
    public function setHome($home)
    {
        $this->home = $home;
    }

    /**
     * @return int|null
     */
    public function getScoreFCMetz()
    {
        return $this->scoreFCMetz;
    }

    /**
     * @param int|null $scoreFCMetz
     */
    public function setScoreFCMetz($scoreFCMetz)
    {
        $this->scoreFCMetz = $scoreFCMetz;
    }

    /**
     * @return int|null
     */
    public function getScoreOpponent()
    {
        return $this->scoreOpponent;
    }

    /**
     * @param int|null $scoreOpponent
     */
    public function setScoreOpponent($scoreOpponent)
    {
        $this->scoreOpponent = $scoreOpponent;
    }


    /**
     * @param int|null $scoreAway
     */
    public function setScoreAway($scoreAway)
    {
        $this->scoreAway = $scoreAway;
    }

    /**
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param mixed $director
     */
    public function setDirector($director)
    {
        $this->director = $director;
    }

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param mixed $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
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
     * Set gameNumber.
     *
     * @param int $gameNumber
     *
     * @return Game
     */
    public function setGameNumber($gameNumber)
    {
        $this->gameNumber = $gameNumber;

        return $this;
    }

    /**
     * Get gameNumber.
     *
     * @return int
     */
    public function getGameNumber()
    {
        return $this->gameNumber;
    }

    /**
     * Set result.
     *
     * @param string|null $result
     *
     * @return Game
     */
    public function setResult($result = null)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result.
     *
     * @return string|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Game
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateWinner()
    {
        if ($this->scoreFCMetz > $this->scoreOpponent) {
            $this->setResult('win');
        } elseif ($this->scoreOpponent > $this->scoreFCMetz) {
            $this->setResult('loss');
        } elseif ($this->scoreFCMetz === null || $this->scoreOpponent === null) {
        } else {
            $this->setResult('draw');
        }
    }
}
