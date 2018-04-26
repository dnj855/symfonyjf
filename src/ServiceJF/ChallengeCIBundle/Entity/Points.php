<?php

namespace ServiceJF\ChallengeCIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Points
 *
 * @ORM\Table(name="ciPoints")
 * @ORM\Entity(repositoryClass="ServiceJF\ChallengeCIBundle\Repository\PointsRepository")
 */
class Points
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
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="liveStudio", type="integer")
     */
    private $liveStudio;

    /**
     * @var int
     *
     * @ORM\Column(name="mandatoryRecordedStudio", type="integer")
     */
    private $mandatoryRecordedStudio;

    /**
     * @var int
     *
     * @ORM\Column(name="nonMandatoryRecordedStudio", type="integer")
     */
    private $nonMandatoryRecordedStudio;

    /**
     * @var int
     *
     * @ORM\Column(name="livePhone", type="integer")
     */
    private $livePhone;

    /**
     * @var int
     *
     * @ORM\Column(name="recordedPhone", type="integer")
     */
    private $recordedPhone;

    /**
     * @var int
     *
     * @ORM\Column(name="hostPoints", type="integer")
     */
    private $hostPoints;

    /**
     * @var int
     *
     * @ORM\Column(name="setterPoints", type="integer")
     */
    private $setterPoints;

    /**
     * @var int
     *
     * @ORM\Column(name="totalPoints", type="integer")
     */
    private $totalPoints;

    /**
     * @var int
     *
     * @ORM\Column(name="totalSet", type="integer")
     */
    private $totalSet;

    /**
     * @return int
     */
    public function getTotalSet()
    {
        return $this->totalSet;
    }

    /**
     * @param int $totalSet
     */
    public function setTotalSet($totalSet)
    {
        $this->totalSet = $totalSet;
    }

    /**
     * @return int
     */
    public function getTotalLiveStudioSet()
    {
        return $this->totalLiveStudioSet;
    }

    /**
     * @param int $totalLiveStudioSet
     */
    public function setTotalLiveStudioSet($totalLiveStudioSet)
    {
        $this->totalLiveStudioSet = $totalLiveStudioSet;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="totalLiveStudioSet", type="integer")
     */
    private $totalLiveStudioSet;

    /**
     * @return int
     */
    public function getHostPoints()
    {
        return $this->hostPoints;
    }

    /**
     * @param int $hostPoints
     */
    public function setHostPoints($hostPoints)
    {
        $this->hostPoints = $hostPoints;
    }

    /**
     * @return int
     */
    public function getSetterPoints()
    {
        return $this->setterPoints;
    }

    /**
     * @param int $setterPoints
     */
    public function setSetterPoints($setterPoints)
    {
        $this->setterPoints = $setterPoints;
    }

    /**
     * @return int
     */
    public function getTotalPoints()
    {
        return $this->totalPoints;
    }

    /**
     * @param int $totalPoints
     */
    public function setTotalPoints($totalPoints)
    {
        $this->totalPoints = $totalPoints;
    }

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceJF\CoreBundle\Entity\Season")
     */
    private $season;


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
     * Set total
     *
     * @param integer $total
     *
     * @return Points
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set liveStudio
     *
     * @param integer $liveStudio
     *
     * @return Points
     */
    public function setLiveStudio($liveStudio)
    {
        $this->liveStudio = $liveStudio;

        return $this;
    }

    /**
     * Get liveStudio
     *
     * @return int
     */
    public function getLiveStudio()
    {
        return $this->liveStudio;
    }

    /**
     * @return int
     */
    public function getMandatoryRecordedStudio()
    {
        return $this->mandatoryRecordedStudio;
    }

    /**
     * @param int $mandatoryRecordedStudio
     */
    public function setMandatoryRecordedStudio($mandatoryRecordedStudio)
    {
        $this->mandatoryRecordedStudio = $mandatoryRecordedStudio;
    }

    /**
     * @return int
     */
    public function getNonMandatoryRecordedStudio()
    {
        return $this->nonMandatoryRecordedStudio;
    }

    /**
     * @param int $nonMandatoryRecordedStudio
     */
    public function setNonMandatoryRecordedStudio($nonMandatoryRecordedStudio)
    {
        $this->nonMandatoryRecordedStudio = $nonMandatoryRecordedStudio;
    }

    /**
     * Set livePhone
     *
     * @param integer $livePhone
     *
     * @return Points
     */
    public function setLivePhone($livePhone)
    {
        $this->livePhone = $livePhone;

        return $this;
    }

    /**
     * Get livePhone
     *
     * @return int
     */
    public function getLivePhone()
    {
        return $this->livePhone;
    }

    /**
     * Set recordedPhone
     *
     * @param integer $recordedPhone
     *
     * @return Points
     */
    public function setRecordedPhone($recordedPhone)
    {
        $this->recordedPhone = $recordedPhone;

        return $this;
    }

    /**
     * Get recordedPhone
     *
     * @return int
     */
    public function getRecordedPhone()
    {
        return $this->recordedPhone;
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
    public function setUser($user)
    {
        $this->user = $user;
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
}

