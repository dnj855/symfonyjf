<?php

namespace ServiceJF\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @ORM\Column(name="phone_number", type="string", length=12, nullable=true)
     * @Assert\Regex(pattern="/^\+33[6-7][0-9]{8}$/", message="Merci d'entrer le numéro au format international (+336...).")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(name="verified_number", type="boolean", nullable=true)
     */
    private $verifiedNumber;

    /**
     * @ORM\Column(name="phone_token_date", type="datetime", nullable=true)
     */
    private $phoneTokenDate;

    /**
     * @ORM\Column(name="phone_token", type="integer", length=6, nullable=true)
     */
    private $phoneToken;

    /**
     * @ORM\Column(name="phone_number_copy", type="string", length=12, nullable=true)
     */
    private $phoneNumberCopy;

    /**
     * @return mixed
     */
    public function getPhoneNumberCopy()
    {
        return $this->phoneNumberCopy;
    }

    /**
     * @param mixed $phoneNumberCopy
     */
    public function setPhoneNumberCopy($phoneNumberCopy)
    {
        $this->phoneNumberCopy = $phoneNumberCopy;
    }

    /**
     * @return mixed
     */
    public function getPhoneTokenDate()
    {
        return $this->phoneTokenDate;
    }

    /**
     * @param mixed $phoneTokenDate
     */
    public function setPhoneTokenDate($phoneTokenDate)
    {
        $this->phoneTokenDate = $phoneTokenDate;
    }

    /**
     * @return mixed
     */
    public function getPhoneToken()
    {
        return $this->phoneToken;
    }

    /**
     * @param mixed $phoneToken
     */
    public function setPhoneToken($phoneToken)
    {
        $this->phoneToken = $phoneToken;
    }

    /**
     * @return mixed
     */
    public function getVerifiedNumber()
    {
        return $this->verifiedNumber;
    }

    /**
     * @param mixed $verifiedNumber
     */
    public function setVerifiedNumber($verifiedNumber)
    {
        $this->verifiedNumber = $verifiedNumber;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

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
     * @ORM\PostLoad
     */
    public function phoneNumberCopy()
    {
        $this->setPhoneNumberCopy($this->getPhoneNumber());
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
