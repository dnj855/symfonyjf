<?php

namespace ServiceJF\ChallengeFGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Vote
 *
 * @ORM\Table(name="fgVote")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeFGBundle\Repository\VoteRepository")
 */
class Vote
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
     * @ORM\Column(name="voteDate", type="date")
     */
    private $voteDate;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     */
    private $voter;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\ChallengeFGBundle\Entity\Punchline", inversedBy="votes")
     */
    private $punchline;

    public function __construct()
    {
        $this->voteDate = new \DateTime();
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
    public function setPunchline($punchline)
    {
        $this->punchline = $punchline;
    }

    /**
     * @return mixed
     */
    public function getVoter()
    {
        return $this->voter;
    }

    /**
     * @param mixed $voter
     */
    public function setVoter($voter)
    {
        $this->voter = $voter;
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
     * Set voteDate
     *
     * @param \DateTime $voteDate
     *
     * @return Vote
     */
    public function setVoteDate($voteDate)
    {
        $this->voteDate = $voteDate;

        return $this;
    }

    /**
     * Get voteDate
     *
     * @return \DateTime
     */
    public function getVoteDate()
    {
        return $this->voteDate;
    }
}

