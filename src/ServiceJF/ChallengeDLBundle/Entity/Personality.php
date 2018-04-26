<?php

namespace ServiceJF\ChallengeDLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personality
 *
 * @ORM\Table(name="dlPersonality")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeDLBundle\Repository\PersonalityRepository")
 */
class Personality
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var bool
     *
     * @ORM\Column(name="dead", type="boolean")
     */
    private $dead;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="smallint", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(name="deathDate", type="date", nullable=true)
     */
    private $deathDate;


    public function __toString()
    {
        if (!$this->getSurname()) {
            return $this->getName();
        } else {
            return $this->getSurname() . " " . $this->getName();
        }
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
     * Set name
     *
     * @param string $name
     *
     * @return Personality
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
     * Set surname
     *
     * @param string $surname
     *
     * @return Personality
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
     * Set dead
     *
     * @param boolean $dead
     *
     * @return Personality
     */
    public function setDead($dead)
    {
        $this->dead = $dead;

        return $this;
    }

    /**
     * Get dead
     *
     * @return bool
     */
    public function getDead()
    {
        return $this->dead;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Personality
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return mixed
     */
    public function getDeathDate()
    {
        return $this->deathDate;
    }

    /**
     * @param mixed $deathDate
     */
    public function setDeathDate($deathDate)
    {
        $this->deathDate = $deathDate;
    }
}

