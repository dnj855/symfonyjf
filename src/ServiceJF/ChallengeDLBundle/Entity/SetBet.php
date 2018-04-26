<?php

namespace ServiceJF\ChallengeDLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * SetBet
 *
 * @ORM\Table(name="dlSetBet")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeDLBundle\Repository\SetBetRepository")
 */
class SetBet
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
     * @ORM\Column(name="bet1", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet1;

    /**
     * @var string
     *
     * @ORM\Column(name="bet2", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet2;

    /**
     * @var string
     *
     * @ORM\Column(name="bet3", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet3;

    /**
     * @var string
     *
     * @ORM\Column(name="bet4", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet4;

    /**
     * @var string
     *
     * @ORM\Column(name="bet5", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet5;

    /**
     * @var string
     *
     * @ORM\Column(name="bet6", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet6;

    /**
     * @var string
     *
     * @ORM\Column(name="bet7", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet7;

    /**
     * @var string
     *
     * @ORM\Column(name="bet8", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet8;

    /**
     * @var string
     *
     * @ORM\Column(name="bet9", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet9;

    /**
     * @var string
     *
     * @ORM\Column(name="bet10", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Il faut remplir les 10 paris.")
     */
    private $bet10;

    /**
     * @var int
     *
     * @ORM\Column(name="joker", type="smallint", nullable=true)
     */
    private $joker;

    /**
     * @ORM\OneToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $better;

    /**
     * @ORM\Column(name="dateBet", type="datetime", nullable=true)
     */
    private $betDate;


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
     * Set joker
     *
     * @param boolean $joker
     *
     * @return SetBet
     */
    public function setJoker($joker)
    {
        $this->joker = $joker;

        return $this;
    }

    /**
     * Get joker
     *
     * @return bool
     */
    public function getJoker()
    {
        return $this->joker;
    }

    /**
     * @return mixed
     */
    public function getBetter()
    {
        return $this->better;
    }

    /**
     * @param mixed $better
     */
    public function setBetter($better)
    {
        $this->better = $better;
    }

    /**
     * @return string
     */
    public function getBet1()
    {
        return $this->bet1;
    }

    /**
     * @param string $bet1
     */
    public function setBet1($bet1)
    {
        $this->bet1 = $bet1;
    }

    /**
     * @return string
     */
    public function getBet2()
    {
        return $this->bet2;
    }

    /**
     * @param string $bet2
     */
    public function setBet2($bet2)
    {
        $this->bet2 = $bet2;
    }

    /**
     * @return string
     */
    public function getBet3()
    {
        return $this->bet3;
    }

    /**
     * @param string $bet3
     */
    public function setBet3($bet3)
    {
        $this->bet3 = $bet3;
    }

    /**
     * @return string
     */
    public function getBet4()
    {
        return $this->bet4;
    }

    /**
     * @param string $bet4
     */
    public function setBet4($bet4)
    {
        $this->bet4 = $bet4;
    }

    /**
     * @return string
     */
    public function getBet5()
    {
        return $this->bet5;
    }

    /**
     * @param string $bet5
     */
    public function setBet5($bet5)
    {
        $this->bet5 = $bet5;
    }

    /**
     * @return string
     */
    public function getBet6()
    {
        return $this->bet6;
    }

    /**
     * @param string $bet6
     */
    public function setBet6($bet6)
    {
        $this->bet6 = $bet6;
    }

    /**
     * @return string
     */
    public function getBet7()
    {
        return $this->bet7;
    }

    /**
     * @param string $bet7
     */
    public function setBet7($bet7)
    {
        $this->bet7 = $bet7;
    }

    /**
     * @return string
     */
    public function getBet8()
    {
        return $this->bet8;
    }

    /**
     * @param string $bet8
     */
    public function setBet8($bet8)
    {
        $this->bet8 = $bet8;
    }

    /**
     * @return string
     */
    public function getBet9()
    {
        return $this->bet9;
    }

    /**
     * @param string $bet9
     */
    public function setBet9($bet9)
    {
        $this->bet9 = $bet9;
    }

    /**
     * @return string
     */
    public function getBet10()
    {
        return $this->bet10;
    }

    /**
     * @param string $bet10
     */
    public function setBet10($bet10)
    {
        $this->bet10 = $bet10;
    }

    public function getBetDate()
    {
        return $this->betDate;
    }

    public function setBetDate($betDate)
    {
        $this->betDate = $betDate;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getBet2() == $this->getBet1()
            || $this->getBet2() == $this->getBet3()
            || $this->getBet2() == $this->getBet4()
            || $this->getBet2() == $this->getBet5()
            || $this->getBet2() == $this->getBet6()
            || $this->getBet2() == $this->getBet7()
            || $this->getBet2() == $this->getBet8()
            || $this->getBet2() == $this->getBet9()
            || $this->getBet2() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet2')
                ->addViolation();
        } elseif ($this->getBet3() == $this->getBet1()
            || $this->getBet3() == $this->getBet4()
            || $this->getBet3() == $this->getBet5()
            || $this->getBet3() == $this->getBet6()
            || $this->getBet3() == $this->getBet7()
            || $this->getBet3() == $this->getBet8()
            || $this->getBet3() == $this->getBet9()
            || $this->getBet3() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet3')
                ->addViolation();
        } elseif ($this->getBet4() == $this->getBet1()
            || $this->getBet4() == $this->getBet5()
            || $this->getBet4() == $this->getBet6()
            || $this->getBet4() == $this->getBet7()
            || $this->getBet4() == $this->getBet8()
            || $this->getBet4() == $this->getBet9()
            || $this->getBet4() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet4')
                ->addViolation();
        } elseif ($this->getBet5() == $this->getBet1()
            || $this->getBet5() == $this->getBet6()
            || $this->getBet5() == $this->getBet7()
            || $this->getBet5() == $this->getBet8()
            || $this->getBet5() == $this->getBet9()
            || $this->getBet5() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet5')
                ->addViolation();
        } elseif ($this->getBet6() == $this->getBet1()
            || $this->getBet6() == $this->getBet7()
            || $this->getBet6() == $this->getBet8()
            || $this->getBet6() == $this->getBet9()
            || $this->getBet6() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet6')
                ->addViolation();
        } elseif ($this->getBet7() == $this->getBet1()
            || $this->getBet7() == $this->getBet8()
            || $this->getBet7() == $this->getBet9()
            || $this->getBet7() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet7')
                ->addViolation();
        } elseif ($this->getBet8() == $this->getBet1()
            || $this->getBet8() == $this->getBet9()
            || $this->getBet8() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet8')
                ->addViolation();
        } elseif ($this->getBet9() == $this->getBet1()
            || $this->getBet9() == $this->getBet10()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet9')
                ->addViolation();
        } elseif ($this->getBet10() == $this->getBet1()) {
            $context->buildViolation("Tu ne peux pas avoir deux noms identiques.")
                ->atPath('bet10')
                ->addViolation();
        }
    }


}

