<?php

namespace ServiceJF\ChallengeCSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ServiceJF\CoreBundle\Entity\Season;
use ServiceJF\UserBundle\Entity\User;

/**
 * Player
 *
 * @ORM\Table(name="cssPlayer")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCSSBundle\Repository\PlayerRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="directedGames", type="integer")
     */
    private $directedGames;

    /**
     * @var int
     *
     * @ORM\Column(name="wonGames", type="integer")
     */
    private $wonGames;

    /**
     * @var int
     *
     * @ORM\Column(name="drawGames", type="integer")
     */
    private $drawGames;

    /**
     * @var int
     *
     * @ORM\Column(name="lostGames", type="integer")
     */
    private $lostGames;

    /**
     * @var int
     *
     * @ORM\Column(name="goalsFor", type="integer")
     */
    private $goalsFor;

    /**
     * @var int
     *
     * @ORM\Column(name="goalsAgainst", type="integer")
     */
    private $goalsAgainst;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="ServiceJF\CoreBundle\Entity\Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\Column(name="goalAverage", type="integer")
     */
    private $goalAverage;

    /**
     * @ORM\Column(name="alternativePoints", type="integer")
     */
    private $alternativePoints;

    public function __construct(User $user, Season $season)
    {
        $this->user = $user;
        $this->season = $season;
        $this->directedGames = 0;
        $this->points = 0;
        $this->goalsFor = 0;
        $this->goalsAgainst = 0;
        $this->wonGames = 0;
        $this->drawGames = 0;
        $this->lostGames = 0;
        $this->alternativePoints = 0;
        $this->goalAverage = 0;
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
     * Set directedGames.
     *
     * @param int $directedGames
     *
     * @return Player
     */
    public function setDirectedGames($directedGames)
    {
        $this->directedGames = $directedGames;

        return $this;
    }

    /**
     * Get directedGames.
     *
     * @return int
     */
    public function getDirectedGames()
    {
        return $this->directedGames;
    }

    /**
     * Set wonGames.
     *
     * @param int $wonGames
     *
     * @return Player
     */
    public function setWonGames($wonGames)
    {
        $this->wonGames = $wonGames;

        return $this;
    }

    /**
     * Get wonGames.
     *
     * @return int
     */
    public function getWonGames()
    {
        return $this->wonGames;
    }

    /**
     * Set drawGames.
     *
     * @param int $drawGames
     *
     * @return Player
     */
    public function setDrawGames($drawGames)
    {
        $this->drawGames = $drawGames;

        return $this;
    }

    /**
     * Get drawGames.
     *
     * @return int
     */
    public function getDrawGames()
    {
        return $this->drawGames;
    }

    /**
     * Set lostGames.
     *
     * @param int $lostGames
     *
     * @return Player
     */
    public function setLostGames($lostGames)
    {
        $this->lostGames = $lostGames;

        return $this;
    }

    /**
     * Get lostGames.
     *
     * @return int
     */
    public function getLostGames()
    {
        return $this->lostGames;
    }

    /**
     * Set goalsFor.
     *
     * @param int $goalsFor
     *
     * @return Player
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;

        return $this;
    }

    /**
     * Get goalsFor.
     *
     * @return int
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * Set goalsAgainst.
     *
     * @param int $goalsAgainst
     *
     * @return Player
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;

        return $this;
    }

    /**
     * Get goalsAgainst.
     *
     * @return int
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
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

    /**
     * @return mixed
     */
    public function getGoalAverage()
    {
        return $this->goalAverage;
    }

    /**
     * @ORM\PrePersist
     */
    public function setGoalAverage($goalAverage)
    {
        $this->goalAverage = $this->getGoalsFor() - $this->getGoalsAgainst();
    }

    /**
     * @return mixed
     */
    public function getAlternativePoints()
    {
        return $this->alternativePoints;
    }

    /**
     * @ORM\PrePersist
     */
    public function setAlternativePoints()
    {
        $this->alternativePoints = ($this->getWonGames() * 3) + ($this->getDrawGames() * 3);
    }

}
