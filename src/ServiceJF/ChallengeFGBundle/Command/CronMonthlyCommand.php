<?php

namespace ServiceJF\ChallengeFGBundle\Command;

use Doctrine\ORM\EntityManager;
use ServiceJF\CoreBundle\Mailer\Mailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronMonthlyCommand extends Command
{
    private $em;

    private $mailer;

    public function __construct(EntityManager $em, Mailer $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('fg:cron-monthly')
            ->setDescription('Sends a reminder for the ChallengeFG.')
            ->setHelp('This command sends an e-mail reminder to all ChallengeFG users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRepository = $this->em->getRepository('ServiceJF\UserBundle\Entity\User');
        $votesRepository = $this->em->getRepository('ServiceJF\ChallengeFGBundle\Entity\Vote');
        $users = $userRepository->findBy(array(
            'enabled' => true
        ));
        $votes = [];
        for ($i = 0; $i < sizeof($users); $i++) {
            $votes[$i] = $votesRepository->getRemainingVotes($users[$i]);
        }
        for ($i = 0; $i < sizeof($users); $i++) {
            if ($votes[$i] != 0) {
                $this->mailer->sendFgReminderMail($users[$i], $votes[$i]);
            }
        }
    }
}