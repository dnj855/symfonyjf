<?php

namespace ServiceJF\ChallengeCM18Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="cm18Bet")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCM18Bundle\Repository\BetRepository")
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
     * @var string
     *
     * @ORM\Column(name="betAway", type="integer")
     */
    private $betAway;

    /**
     * @var string
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
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Game", inversedBy="bets")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Player", cascade={"persist"})
     */
    private $player;

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
     * @return string
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param string $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
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
     * @param string $betAway
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
     * @return string
     */
    public function getBetAway()
    {
        return $this->betAway;
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
     * Set result.
     *
     * @param string $result
     *
     * @return Bet
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result.
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
}
