<?php
/**
 * User: cedriclangroth
 * Date: 08/05/2018
 * Time: 15:10
 */

namespace ServiceJF\ChallengeCM18Bundle\Services;


use Doctrine\ORM\EntityManager;

class PrizeMoneyCalculator
{
    private $em;

    private $first;

    private $second;

    /**
     * @return mixed
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @param mixed $first
     */
    public function setFirst($first)
    {
        $this->first = $first;
    }

    /**
     * @return mixed
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @param mixed $second
     */
    public function setSecond($second)
    {
        $this->second = $second;
    }

    /**
     * @return mixed
     */
    public function getThird()
    {
        return $this->third;
    }

    /**
     * @param mixed $third
     */
    public function setThird($third)
    {
        $this->third = $third;
    }

    private $third;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getPrizeMoney($betValue)
    {
        $players = $this->em->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')->findAll();
        $this->setFirst((count($players) * $betValue) * 70 / 100);
        $this->setSecond((count($players) * $betValue) * 20 / 100);
        $this->setThird((count($players) * $betValue) * 10 / 100);
        return $this;
    }
}