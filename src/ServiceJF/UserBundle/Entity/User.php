<?php

namespace ServiceJF\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ServiceJF\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var bool
     *
     * @ORM\Column(name="cadre", type="boolean", nullable=true)
     */
    private $manager;

    /**
     * @ORM\Column(name="surname", type="string", length=50)
     */
    private $surname;

    /**
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\CoreBundle\Entity\Service")
     */
    private $service;

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    public function eraseCredentials()
    {

    }

    /**
     * Set manager
     *
     * @param boolean $manager
     *
     * @return User
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return boolean
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * @ORM\PrePersist
     */
    public function journalists()
    {
        if ($this->getService()->getName() == 'Rédaction') {
            $this->addRole('ROLE_CI');
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function journalistsUpdate()
    {
        if ($this->getService()->getName() == 'Rédaction') {
            $this->addRole('ROLE_CI');
        }
    }
}
