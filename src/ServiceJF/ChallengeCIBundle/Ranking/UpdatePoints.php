<?php
/**
 * User: cedriclangroth
 * Date: 01/01/2018
 * Time: 21:44
 */

namespace ServiceJF\ChallengeCIBundle\Ranking;


use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeCIBundle\Entity\Points;
use ServiceJF\CoreBundle\Entity\Season;
use ServiceJF\UserBundle\Entity\User;

class UpdatePoints
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function updateHost(User $host, Season $season)
    {
        $points = $this->em->getRepository('ServiceJF\ChallengeCIBundle\Entity\Points')
            ->findByUserAndSeason($host, $season);
        if ($points == null) {
            $points = new Points();
            $points->setSeason($season);
            $points->setUser($host);
            $points->setTotalSet('0');
            $points->setTotalLiveStudioSet('0');
        }
        $guestRepository = $this->em->getRepository('ServiceJF\ChallengeCIBundle\Entity\Guest');
        $total = $guestRepository->getTotalGuests($host, $season);
        $liveStudio = $guestRepository->getLiveStudioGuests($host, $season);
        $livePhone = $guestRepository->getLivePhoneGuests($host, $season);
        $recordedPhone = $guestRepository->getRecordedPhoneGuests($host, $season);
        $mandatoryRecordedStudio = $guestRepository->getRecordedStudioMandatoryGuests($host, $season);
        $nonMandatoryRecordedStudio = $guestRepository->getRecordedStudioNonMandatoryGuests($host, $season);
        if ($liveStudio == null) {
            $liveStudio = '0';
        }
        if ($livePhone == null) {
            $livePhone = '0';
        }
        if ($recordedPhone == null) {
            $recordedPhone = '0';
        }
        if ($mandatoryRecordedStudio == null) {
            $mandatoryRecordedStudio = '0';
        }
        if ($nonMandatoryRecordedStudio == null) {
            $nonMandatoryRecordedStudio = '0';
        }
        $points->setTotal($total);
        $points->setLiveStudio($liveStudio);
        $points->setLivePhone($livePhone);
        $points->setRecordedPhone($recordedPhone);
        $points->setMandatoryRecordedStudio($mandatoryRecordedStudio);
        $points->setNonMandatoryRecordedStudio($nonMandatoryRecordedStudio);
        if ($points->getSetterPoints() == null) {
            $points->setSetterPoints(0);
        }
        $hostPoints = round(($liveStudio / $total) * 300) + round(($livePhone / $total) * 200)
            + round(($recordedPhone / $total) * 100) + round(($mandatoryRecordedStudio / $total) * 300)
            + round(($nonMandatoryRecordedStudio / $total) * 100);
        $points->setHostPoints($hostPoints);
        $points->setTotalPoints($points->getHostPoints() + $points->getSetterPoints());
        $this->em->persist($points);
        $this->em->flush();
    }

    public function updateSetter(User $setter, Season $season)
    {
        $points = $this->em->getRepository('ServiceJF\ChallengeCIBundle\Entity\Points')
            ->findByUserAndSeason($setter, $season);
        if ($points == null) {
            $points = new Points();
            $points->setSeason($season);
            $points->setUser($setter);
            $points->setTotal('0');
            $points->setNonMandatoryRecordedStudio('0');
            $points->setMandatoryRecordedStudio('0');
            $points->setRecordedPhone('0');
            $points->setLivePhone('0');
            $points->setLiveStudio('0');
        }
        $guestRepository = $this->em->getRepository('ServiceJF\ChallengeCIBundle\Entity\Guest');
        $totalSet = $guestRepository->getSetGuests($setter, $season);
        if ($totalSet != 0) {
            $totalLiveStudioSet = $guestRepository->getSetLiveStudioGuests($setter, $season);
            $setPoints = round(($totalLiveStudioSet / $totalSet) * 100);
            if ($points->getHostPoints() == null) {
                $points->setHostPoints(0);
            }
            $points->setSetterPoints($setPoints);
            $points->setTotalPoints($points->getHostPoints() + $points->getSetterPoints());
            $points->setTotalSet($totalSet);
            $points->setTotalLiveStudioSet($totalLiveStudioSet);
            $this->em->persist($points);
            $this->em->flush();
        }
    }
}