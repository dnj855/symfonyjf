<?php

namespace ServiceJF\ChallengeFGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Punchline
 *
 * @ORM\Table(name="fgPunchline")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeFGBundle\Repository\PunchlineRepository")
 */
class Punchline
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
     * @ORM\Column(name="punchline", type="text")
     */
    private $punchline;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="date")
     */
    private $postDate;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="punchline")
     */
    private $votes;

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param mixed $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="poster", nullable=false)
     */
    private $poster;

    public function __construct()
    {
        $this->enable();
        $this->postDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    public function enable()
    {
        $this->enabled = 1;
    }

    public function disable()
    {
        $this->enabled = 0;
    }

    /**
     * @return mixed
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param mixed $poster
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
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
     * Set punchline
     *
     * @param string $punchline
     *
     * @return Punchline
     */
    public function setPunchline($punchline)
    {
        $this->punchline = $punchline;

        return $this;
    }

    /**
     * Get punchline
     *
     * @return string
     */
    public function getPunchline()
    {
        return $this->punchline;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Punchline
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }
}

