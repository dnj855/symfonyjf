<?php

namespace ServiceJF\ChallengeCIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Guest
 *
 * @ORM\Table(name="ciGuest")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCIBundle\Repository\GuestRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="date", message="Un seul invité par jour, merci !")
 */
class Guest
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
     * @var bool
     *
     * @ORM\Column(name="studio", type="boolean")
     */
    private $studio;

    /**
     * @var bool
     *
     * @ORM\Column(name="live", type="boolean")
     */
    private $live;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="mandatoryRecorded", type="boolean")
     */
    private $mandatoryRecorded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", unique=true)
     * @Assert\Date(message="Merci de saisir une date.")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $setter;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $host;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\CoreBundle\Entity\Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    private $color;

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @ORM\PostLoad
     */
    public function setColor() {
        if ($this->live && $this->studio) {
            $this->color = 'green';
        } elseif (!$this->live && $this->studio && $this->mandatoryRecorded) {
            $this->color = 'green';
        } elseif (($this->live && !$this->studio) || (!$this->live && $this->studio)) {
            $this->color = 'orange';
        } else {
            $this->color = 'red';
        }
    }

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getSetter()
    {
        return $this->setter;
    }

    /**
     * @param mixed $setter
     */
    public function setSetter($setter)
    {
        $this->setter = $setter;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set studio
     *
     * @param boolean $studio
     *
     * @return Guest
     */
    public function setStudio($studio)
    {
        $this->studio = $studio;

        return $this;
    }

    /**
     * Get studio
     *
     * @return bool
     */
    public function getStudio()
    {
        return $this->studio;
    }

    /**
     * Set live
     *
     * @param boolean $live
     *
     * @return Guest
     */
    public function setLive($live)
    {
        $this->live = $live;

        return $this;
    }

    /**
     * Get live
     *
     * @return bool
     */
    public function getLive()
    {
        return $this->live;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Guest
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isMandatoryRecorded()
    {
        return $this->mandatoryRecorded;
    }

    /**
     * @param bool $mandatoryRecorded
     */
    public function setMandatoryRecorded($mandatoryRecorded)
    {
        $this->mandatoryRecorded = $mandatoryRecorded;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Guest
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

