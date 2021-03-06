<?php

namespace ServiceJF\ChallengeCM18Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GamePhase
 *
 * @ORM\Table(name="cm18GamePhase")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCM18Bundle\Repository\GamePhaseRepository")
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="eliminatory", type="boolean")
     */
    private $eliminatory;

    /**
     * @var bool
     *
     * @ORM\Column(name="final", type="boolean")
     */
    private $final;

    /**
     * @var @ORM\OneToMany(targetEntity="ServiceJF\ChallengeCM18Bundle\Entity\Game", mappedBy="gamePhase")
     */
    private $games;

    /**
     * @return mixed
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param mixed $games
     */
    public function setGames($games)
    {
        $this->games = $games;
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
     * @return GamePhase
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
     * Set eliminatory.
     *
     * @param bool $eliminatory
     *
     * @return GamePhase
     */
    public function setEliminatory($eliminatory)
    {
        $this->eliminatory = $eliminatory;

        return $this;
    }

    /**
     * Get eliminatory.
     *
     * @return bool
     */
    public function getEliminatory()
    {
        return $this->eliminatory;
    }

    /**
     * Set final.
     *
     * @param bool $final
     *
     * @return GamePhase
     */
    public function setFinal($final)
    {
        $this->final = $final;

        return $this;
    }

    /**
     * Get final.
     *
     * @return bool
     */
    public function getFinal()
    {
        return $this->final;
    }
}
