<?php
/**
 * User: cedriclangroth
 * Date: 02/08/2018
 * Time: 09:40
 */

namespace ServiceJF\CoreBundle\SMS;


use Doctrine\ORM\EntityManager;
use ServiceJF\UserBundle\Entity\User;

class SMSChecker
{
    private $smsInterface;
    private $em;

    public function __construct(EntityManager $em, SMSInterface $smsInterface)
    {
        $this->em = $em;
        $this->smsInterface = $smsInterface;
    }

    public function checkProcess(User $user)
    {
        $token = random_int(100000, 999999);
        $user->setPhoneToken($token);
        $user->setVerifiedNumber(false);
        $user->setPhoneTokenDate(new \DateTime());
        $this
            ->smsInterface
            ->sendSMS(array($user->getPhoneNumber()), 'Ton code pour valider ton numero de téléphone est le ' . $token . '. Ou sinon, clique sur ce lien : https://www.servicejf.com/confirm-sms/' . $token);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function updateProcess(User $user)
    {
        $token = random_int(100000, 999999);
        $user->setPhoneToken($token);
        $user->setVerifiedNumber(false);
        $user->setPhoneTokenDate(new \DateTime());
        $this
            ->smsInterface
            ->sendSMS(array($user->getPhoneNumber()), 'Ton code pour valider ton numero de téléphone est le ' . $token . '. Ou sinon, clique sur ce lien : https://www.servicejf.com/confirm-sms/' . $token);
        return $user;
    }
}