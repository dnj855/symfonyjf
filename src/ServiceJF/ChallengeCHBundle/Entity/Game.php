<?php

namespace ServiceJF\ChallengeCHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="chGame")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCHBundle\Repository\GameRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="scoreHome", type="integer", nullable=true)
     */
    private $scoreHome;

    /**
     * @var int
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
     * @var int|null
     *
     * @ORM\Column(name="gap", type="integer", nullable=true)
     */
    private $gap;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCHBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamHome;

    /**
 * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCHBundle\Entity\Team")
 * @ORM\JoinColumn(nullable=false)
 */
    private $teamAway;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCHBundle\Entity\GamePhase")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gamePhase;

    /**
     * @ORM\OneToMany(targetEntity="ServiceJF\ChallengeCHBundle\Entity\Bet", mappedBy="game", cascade={"persist"})
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set scoreHome.
     *
     * @param int $scoreHome
     *
     * @return Game
     */
    public function setScoreHome($scoreHome)
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    /**
     * Get scoreHome.
     *
     * @return int
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreAway.
     *
     * @param int $scoreAway
     *
     * @return Game
     */
    public function setScoreAway($scoreAway)
    {
        $this->scoreAway = $scoreAway;

        return $this;
    }

    /**
     * Get scoreAway.
     *
     * @return int
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
     * @return int|null
     */
    public function getGap()
    {
        return $this->gap;
    }

    /**
     * @param int|null $gap
     */
    public function setGap($gap)
    {
        $this->gap = $gap;
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
     * @ORM\PreUpdate
     */
    public function updateRoutine()
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
        if ($this->scoreHome !== null && $this->scoreAway !== null) {
            $this->gap = abs($this->scoreHome - $this->scoreAway);
        }
    }
}
