<?php

namespace ServiceJF\ChallengeCM18Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="cm18Game")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCM18Bundle\Repository\GameRepository")
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
     * @ORM\Column(name="fifaNumber", type="integer", unique=true)
     */
    private $fifaNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="scoreHome", type="integer", nullable=true)
     */
    private $scoreHome;

    /**
     * @var int|null
     *
     * @ORM\Column(name="scoreAway", type="integer", nullable=true)
     */
    private $scoreAway;

    /**
     * @var string|null
     *
     * @ORM\Column(name="result", type="string", length=4, nullable=true)
     */
    private $result;

    /**
     * @var string|null
     *
     * @ORM\Column(name="winner", type="string", length=4, nullable=true)
     */
    private $winner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Team", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $teamHome;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Team", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $teamAway;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\GamePhase", inversedBy="games")
     */
    private $gamePhase;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Pool")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pool;

    /**
     * @ORM\OneToMany(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Bet", mappedBy="game", cascade={"persist"})
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
     * @return mixed
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * @param mixed $teamHome
     */
    public function setTeamHome($teamHome)
    {
        $this->teamHome = $teamHome;
    }

    /**
     * @return mixed
     */
    public function getTeamAway()
    {
        return $this->teamAway;
    }

    /**
     * @param mixed $teamAway
     */
    public function setTeamAway($teamAway)
    {
        $this->teamAway = $teamAway;
    }

    /**
     * @return mixed
     */
    public function getGamePhase()
    {
        return $this->gamePhase;
    }

    /**
     * @param mixed $gamePhase
     */
    public function setGamePhase($gamePhase)
    {
        $this->gamePhase = $gamePhase;
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
     * Set fifaNumber.
     *
     * @param int $fifaNumber
     *
     * @return Game
     */
    public function setFifaNumber($fifaNumber)
    {
        $this->fifaNumber = $fifaNumber;

        return $this;
    }

    /**
     * Get fifaNumber.
     *
     * @return int
     */
    public function getFifaNumber()
    {
        return $this->fifaNumber;
    }

    /**
     * Set scoreHome.
     *
     * @param int|null $scoreHome
     *
     * @return Game
     */
    public function setScoreHome($scoreHome = null)
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    /**
     * Get scoreHome.
     *
     * @return int|null
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreAway.
     *
     * @param int|null $scoreAway
     *
     * @return Game
     */
    public function setScoreAway($scoreAway = null)
    {
        $this->scoreAway = $scoreAway;

        return $this;
    }

    /**
     * Get scoreAway.
     *
     * @return int|null
     */
    public function getScoreAway()
    {
        return $this->scoreAway;
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
     * Set winner.
     *
     * @param string|null $winner
     *
     * @return Game
     */
    public function setWinner($winner = null)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner.
     *
     * @return string|null
     */
    public function getWinner()
    {
        return $this->winner;
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
        if ($this->scoreHome > $this->scoreAway) {
            $this->setResult('home');
            $this->setWinner('home');
        } elseif ($this->scoreAway > $this->scoreHome) {
            $this->setResult('away');
            $this->setWinner('away');
        } elseif ($this->scoreHome === null || $this->scoreAway === null) {
        } else {
            $this->setResult('draw');
        }
    }
}
