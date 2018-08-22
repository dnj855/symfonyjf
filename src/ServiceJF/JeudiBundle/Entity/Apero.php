<?php

namespace ServiceJF\JeudiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ServiceJF\UserBundle\Entity\User;

/**
 * Apero
 *
 * @ORM\Table(name="jeudiApero")
 * @ORM\Entity(repositoryClass="ServiceJF\JeudiBundle\Repository\AperoRepository")
 */
class Apero
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
     * @ORM\Column(name="date", type="date", unique=true)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="display_date", type="datetime", unique=true)
     */
    private $displayDate;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\ManyToMany(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinTable(name="jeudiInterested")
     */
    private $interestedUsers;

    /**
     * @ORM\Column(name="place_set", type="boolean", nullable=false)
     */
    private $placeSet;

    /**
     * Apero constructor.
     * @param $date
     * @param $number
     */
    public function __construct($date, $number)
    {
        $this->date = $date;
        $this->number = $number;
        $this->displayDate = $date;
        $this->interestedUsers = new ArrayCollection();
        $this->placeSet = false;
    }

    public function addInterestedUser(User $user)
    {
        $this->interestedUsers[] = $user;
    }

    /**
     * @return mixed
     */
    public function getInterestedUsers()
    {
        return $this->interestedUsers;
    }

    /**
     * @return \DateTime
     */
    public function getDisplayDate()
    {
        return $this->displayDate;
    }

    /**
     * @param \DateTime $displayDate
     */
    public function setDisplayDate($displayDate)
    {
        $this->displayDate = $displayDate;
    }


    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
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
     * @return Apero
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
     * Set number.
     *
     * @param int $number
     *
     * @return Apero
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set place.
     *
     * @param string|null $place
     *
     * @return Apero
     */
    public function setPlace($place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return string|null
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return mixed
     */
    public function getPlaceSet()
    {
        return $this->placeSet;
    }

    /**
     * @param mixed $placeSet
     */
    public function setPlaceSet($placeSet)
    {
        $this->placeSet = $placeSet;
    }
}
