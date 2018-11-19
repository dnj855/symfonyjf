<?php

namespace ServiceJF\ChallengeCHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="chBet")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCHBundle\Repository\BetRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Bet
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
     * @ORM\Column(name="betHome", type="integer")
     */
    private $betHome;

    /**
     * @var int
     *
     * @ORM\Column(name="betAway", type="integer")
     */
    private $betAway;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var string
     *
     * @ORM\Column(name="winner", type="string", length=4)
     */
    private $winner;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=4)
     */
    private $result;

    /**
     * @var int
     *
     * @ORM\Column(name="p1n2", type="integer", nullable=true)
     */
    private $p1n2;

    /**
     * @var int
     *
     * @ORM\Column(name="pGap", type="integer", nullable=true)
     */
    private $pGap;

    /**
     * @var int
     *
     * @ORM\Column(name="pPerfect", type="integer", nullable=true)
     */
    private $pPerfect;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCHBundle\Entity\Game", inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCHBundle\Entity\Player", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(name="gap", type="integer", nullable=true)
     */
    private $gap;

    public function __construct(Game $game, Player $player)
    {
        $this->game = $game;
        $this->player = $player;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
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
     * Set betHome.
     *
     * @param int $betHome
     *
     * @return Bet
     */
    public function setBetHome($betHome)
    {
        $this->betHome = $betHome;

        return $this;
    }

    /**
     * Get betHome.
     *
     * @return int
     */
    public function getBetHome()
    {
        return $this->betHome;
    }

    /**
     * Set betAway.
     *
     * @param int $betAway
     *
     * @return Bet
     */
    public function setBetAway($betAway)
    {
        $this->betAway = $betAway;

        return $this;
    }

    /**
     * Get betAway.
     *
     * @return int
     */
    public function getBetAway()
    {
        return $this->betAway;
    }

    /**
     * Set points.
     *
     * @param int|null $points
     *
     * @return Bet
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

    /**
     * Set winner.
     *
     * @param string $winner
     *
     * @return Bet
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner.
     *
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set p1n2.
     *
     * @param int $p1n2
     *
     * @return Bet
     */
    public function setP1n2($p1n2)
    {
        $this->p1n2 = $p1n2;

        return $this;
    }

    /**
     * Get p1n2.
     *
     * @return int
     */
    public function getP1n2()
    {
        return $this->p1n2;
    }

    /**
     * @return int
     */
    public function getPGap()
    {
        return $this->pGap;
    }

    /**
     * @param int $pGap
     */
    public function setPGap($pGap)
    {
        $this->pGap = $pGap;
    }


    /**
     * Set pPerfect.
     *
     * @param int $pPerfect
     *
     * @return Bet
     */
    public function setPPerfect($pPerfect)
    {
        $this->pPerfect = $pPerfect;

        return $this;
    }

    /**
     * Get pPerfect.
     *
     * @return int
     */
    public function getPPerfect()
    {
        return $this->pPerfect;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateRoutine()
    {
        if ($this->betHome > $this->betAway) {
            $this->setResult('home');
            $this->setWinner('home');
        } elseif ($this->betAway > $this->betHome) {
            $this->setResult('away');
            $this->setWinner('away');
        } elseif ($this->betHome === null || $this->betAway === null) {
        } else {
            $this->setResult('draw');
        }
        if ($this->betHome !== null && $this->betAway !== null) {
            $this->gap = abs($this->betHome - $this->betAway);
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function persistRoutine()
    {
        if ($this->betHome > $this->betAway) {
            $this->setResult('home');
            $this->setWinner('home');
        } elseif ($this->betAway > $this->betHome) {
            $this->setResult('away');
            $this->setWinner('away');
        } elseif ($this->betHome === null || $this->betAway === null) {
        } else {
            $this->setResult('draw');
        }
        if ($this->betHome !== null && $this->betAway !== null) {
            $this->gap = abs($this->betHome - $this->betAway);
        }
    }

    /**
     * @return mixed
     */
    public function getGap()
    {
        return $this->gap;
    }

    /**
     * @param mixed $gap
     */
    public function setGap($gap)
    {
        $this->gap = $gap;
    }
}
