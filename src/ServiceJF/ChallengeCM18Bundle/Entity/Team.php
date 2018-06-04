<?php

namespace ServiceJF\ChallengeCM18Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="cm18Team")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCM18Bundle\Repository\TeamRepository")
 */
class Team
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="playedGames", type="integer")
     */
    private $playedGames;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var int
     *
     * @ORM\Column(name="goalAverage", type="integer")
     */
    private $goalAverage;

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
     * @ORM\Column(name="won", type="integer")
     */
    private $won;

    /**
     * @var int
     *
     * @ORM\Column(name="draw", type="integer")
     */
    private $draw;

    /**
     * @var int
     *
     * @ORM\Column(name="lost", type="integer")
     */
    private $lost;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Pool", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pool;

    /**
     * @ORM\Column(name="flag", type="string", length=6)
     */
    private $flag;

    /**
     * @return mixed
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param mixed $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    public function __construct()
    {
        $this->points = 0;
        $this->draw = 0;
        $this->goalAverage = 0;
        $this->goalsAgainst = 0;
        $this->goalsFor = 0;
        $this->lost = 0;
        $this->playedGames = 0;
        $this->won = 0;
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
     * Set name.
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set playedGames.
     *
     * @param int $playedGames
     *
     * @return Team
     */
    public function setPlayedGames($playedGames)
    {
        $this->playedGames = $playedGames;

        return $this;
    }

    /**
     * Get playedGames.
     *
     * @return int
     */
    public function getPlayedGames()
    {
        return $this->playedGames;
    }

    /**
     * Set points.
     *
     * @param int $points
     *
     * @return Team
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
     * Set goalAverage.
     *
     * @param int $goalAverage
     *
     * @return Team
     */
    public function setGoalAverage($goalAverage)
    {
        $this->goalAverage = $goalAverage;

        return $this;
    }

    /**
     * Get goalAverage.
     *
     * @return int
     */
    public function getGoalAverage()
    {
        return $this->goalAverage;
    }

    /**
     * Set goalsFor.
     *
     * @param int $goalsFor
     *
     * @return Team
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
     * Set goalsAgains.
     *
     * @param int $goalsAgains
     *
     * @return Team
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;

        return $this;
    }

    /**
     * Get goalsAgains.
     *
     * @return int
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * Set won.
     *
     * @param int $won
     *
     * @return Team
     */
    public function setWon($won)
    {
        $this->won = $won;

        return $this;
    }

    /**
     * Get won.
     *
     * @return int
     */
    public function getWon()
    {
        return $this->won;
    }

    /**
     * Set draw.
     *
     * @param int $draw
     *
     * @return Team
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;

        return $this;
    }

    /**
     * Get draw.
     *
     * @return int
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * Set lost.
     *
     * @param int $lost
     *
     * @return Team
     */
    public function setLost($lost)
    {
        $this->lost = $lost;

        return $this;
    }

    /**
     * Get lost.
     *
     * @return int
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * @return mixed
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param mixed $pool
     */
    public function setPool($pool)
    {
        $this->pool = $pool;
    }

    public function poolGame($result, $goalsFor, $goalsAgainst)
    {
        $this->setPlayedGames($this->getPlayedGames() + 1);
        $this->setGoalsFor($this->getGoalsFor() + $goalsFor);
        $this->setGoalsAgainst($this->getGoalsAgainst() + $goalsAgainst);
        $this->setGoalAverage($this->getGoalsFor() - $this->getGoalsAgainst());
        if ($result == "win") {
            $this->setWon($this->getWon() + 1);
            $this->setPoints($this->getPoints() + 3);
        } elseif ($result == "draw") {
            $this->setDraw($this->getDraw() + 1);
            $this->setPoints($this->getPoints() + 1);
        } else {
            $this->setLost($this->getLost() + 1);
        }
    }
}
