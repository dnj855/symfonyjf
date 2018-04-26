<?php

namespace ServiceJF\ChallengeFGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BestPunchline
 *
 * @ORM\Table(name="fgBestPunchline")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeFGBundle\Repository\BestPunchlineRepository")
 */
class BestPunchline
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
     * @ORM\Column(name="month", type="date", unique=true)
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="totalVotes", type="integer")
     */
    private $totalVotes;

    /**
     * @var int
     *
     * @ORM\Column(name="punchlineVotes", type="integer")
     */
    private $punchlineVotes;

    /**
     * @ORM\OneToOne(targetEntity="Punchline")
     * @ORM\JoinColumn(nullable=false)
     */
    private $punchline;

    public function __construct(\DateTimeImmutable $month, $punchlineVotes, $totalVotes)
    {
        $this->month = $month;
        $this->punchlineVotes = $punchlineVotes;
        $this->totalVotes = $totalVotes;
    }

    /**
     * @return mixed
     */
    public function getPunchline()
    {
        return $this->punchline;
    }

    /**
     * @param mixed $punchline
     */
    public function setPunchline(Punchline $punchline)
    {
        $this->punchline = $punchline;
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
     * Set month
     *
     * @param \DateTime $month
     *
     * @return BestPunchline
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return \DateTime
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set totalVotes
     *
     * @param integer $totalVotes
     *
     * @return BestPunchline
     */
    public function setTotalVotes($totalVotes)
    {
        $this->totalVotes = $totalVotes;

        return $this;
    }

    /**
     * Get totalVotes
     *
     * @return int
     */
    public function getTotalVotes()
    {
        return $this->totalVotes;
    }

    /**
     * Set punchlineVotes
     *
     * @param integer $punchlineVotes
     *
     * @return BestPunchline
     */
    public function setPunchlineVotes($punchlineVotes)
    {
        $this->punchlineVotes = $punchlineVotes;

        return $this;
    }

    /**
     * Get punchlineVotes
     *
     * @return int
     */
    public function getPunchlineVotes()
    {
        return $this->punchlineVotes;
    }
}

