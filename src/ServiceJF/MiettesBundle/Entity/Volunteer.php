<?php

namespace ServiceJF\MiettesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ServiceJF\UserBundle\Entity\User;

/**
 * Volunteer
 *
 * @ORM\Table(name="miettesVolunteer")
 * @ORM\Entity(repositoryClass="ServiceJF\MiettesBundle\Repository\VolunteerRepository")
 */
class Volunteer
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
     * @ORM\Column(name="virtual_cleanups", type="integer")
     */
    private $virtualCleanups;

    /**
     * @var int
     *
     * @ORM\Column(name="real_cleanups", type="integer")
     */
    private $realCleanups;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_cleanup", type="datetime", nullable=true)
     */
    private $lastCleanup;

    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->active = true;
        $this->realCleanups = 0;
    }

    public function __toString()
    {
        return $this->getUser()->getSurname() . ' ' . $this->getUser()->getName();
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
     * @return int
     */
    public function getVirtualCleanups()
    {
        return $this->virtualCleanups;
    }

    /**
     * @param int $virtualCleanups
     */
    public function setVirtualCleanups($virtualCleanups)
    {
        $this->virtualCleanups = $virtualCleanups;
    }

    /**
     * @return int
     */
    public function getRealCleanups()
    {
        return $this->realCleanups;
    }

    /**
     * @param int $realCleanups
     */
    public function setRealCleanups($realCleanups)
    {
        $this->realCleanups = $realCleanups;
    }


    /**
     * Set lastCleanup.
     *
     * @param \DateTime|null $lastCleanup
     *
     * @return Volunteer
     */
    public function setLastCleanup($lastCleanup = null)
    {
        $this->lastCleanup = $lastCleanup;

        return $this;
    }

    /**
     * Get lastCleanup.
     *
     * @return \DateTime|null
     */
    public function getLastCleanup()
    {
        return $this->lastCleanup;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }


}
