<?php
/**
 * User: cedriclangroth
 * Date: 14/07/2018
 * Time: 11:03
 */

namespace ServiceJF\JeudiBundle\Controller;


use ServiceJF\JeudiBundle\Entity\Apero;
use ServiceJF\JeudiBundle\Form\AperoType;
use ServiceJF\UserBundle\Entity\User;
use ServiceJF\UserBundle\Form\UserJeudiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CoreController extends Controller
{
    public function indexAction()
    {
        $aperoRepository = $this->getDoctrine()->getRepository('ServiceJF\JeudiBundle\Entity\Apero');
        $next = $aperoRepository->findNext();
        if ($next === null) {
            $last = $aperoRepository->findLast();
            if ($last === null) {
                $lastNumber = 29;
            } else {
                $lastNumber = $last->getNumber();
            }
            $nextDate = new \DateTime();
            $nextDate->modify('next Thursday');
            $next = new Apero($nextDate, $lastNumber + 1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($next);
            $em->flush();
        }
        $interestedUsers = $next->getInterestedUsers();
        if (in_array($this->getUser(), $interestedUsers->toArray())) {
            $interested = true;
        } else {
            $interested = false;
        }
        return $this->render('ServiceJFJeudiBundle:core:index.html.twig', array(
            'next' => $next,
            'interested' => $interested
        ));
    }

    public function adminAction(Request $request, Session $session)
    {
        $aperoRepository = $this->getDoctrine()->getRepository('ServiceJF\JeudiBundle\Entity\Apero');
        $nextToConfirm = $aperoRepository->findNextToConfirm();
        $nextToEdit = $aperoRepository->findNextToEdit();
        if ($nextToEdit === null) {
            $interestedUsers = $nextToConfirm->getInterestedUsers();
            return $this->render('ServiceJFJeudiBundle:core:admin.html.twig', array(
                'nextToConfirm' => $nextToConfirm,
                'nextToEdit' => $nextToEdit,
                'interestedUsers' => $interestedUsers
            ));
        } else {
            $nextBeforeEdition = clone $nextToEdit;
            $mailer = $this->get('servicejf_jeudi.mailer');
            $smsInterface = $this->get('servicejf.smsinterface');
            $interestedUsers = $nextToEdit->getInterestedUsers();
            if ($nextToConfirm) {
                $confirmInterestedUsers = $nextToConfirm->getInterestedUsers();
            } else {
                $confirmInterestedUsers = null;
            }
            $form = $this->createForm(AperoType::class, $nextToEdit);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $session->getFlashBag()->add('success', 'Les détails ont bien été enregistrés.');
                $phoneNumbers = $smsInterface->getPhoneNumbers($interestedUsers);
                if ($nextToEdit->getPlaceSet() == false) {
                    $mailer->timeAndPlaceMail($interestedUsers, $nextToEdit, true);
                    $smsInterface
                        ->sendSMS($phoneNumbers, 'Le prochain apéro du jeudi aura lieu à ' . $nextToEdit->getPlace() . '! Vérifie tes mails pour plus d\'infos !');
                    $nextToEdit->setPlaceSet(true);
                } else {
                    if ($nextBeforeEdition->getPlace() == $nextToEdit->getPlace() && $nextBeforeEdition->getDisplayDate() == $nextToEdit->getDisplayDate()) {

                    } elseif ($nextBeforeEdition->getPlace() == $nextToEdit->getPlace()) {
                        $mailer->timeAndPlaceMail($interestedUsers, $nextToEdit, false, false, true);
                    } elseif ($nextBeforeEdition->getDisplayDate() == $nextToEdit->getDisplayDate()) {
                        $mailer->timeAndPlaceMail($interestedUsers, $nextToEdit, false, true, false);
                        $smsInterface
                            ->sendSMS($phoneNumbers, 'Attention, il y a eu un changement de lieu pour le prochain apéro. C\'est désormais à ' . $nextToEdit->getPlace() . ' !');
                    } else {
                        $mailer->timeAndPlaceMail($interestedUsers, $nextToEdit, false, true, true);
                        $smsInterface
                            ->sendSMS($phoneNumbers, 'Attention, il y a eu un changement de lieu pour le prochain apéro. C\'est désormais à ' . $nextToEdit->getPlace() . ' !');
                    }
                }
                $this->getDoctrine()->getManager()->flush();
            }
            return $this->render('ServiceJFJeudiBundle:core:admin.html.twig', array(
                'nextToConfirm' => $nextToConfirm,
                'nextToEdit' => $nextToEdit,
                'form' => $form->createView(),
                'interestedUsers' => $interestedUsers,
                'confirmInterestedUsers' => $confirmInterestedUsers
            ));
        }
    }

    public function adminConfirmAction(Apero $apero, Session $session)
    {
        $apero->setEnabled(true);
        $this->getDoctrine()->getManager()->flush();
        $interestedUsers = $apero->getInterestedUsers();
        $mailer = $this->get('servicejf_jeudi.mailer');
        $mailer->confirmMail($interestedUsers, $apero);
        $session->getFlashBag()->add('success', 'L\'apéro #' . $apero->getNumber() . ' a bien été confirmé.');
        return $this->redirectToRoute('servicejf_jeudi_admin');
    }

    public function adminRejectAction(Apero $apero, Session $session)
    {
        $apero->setEnabled(false);
        $interestedUsers = $apero->getInterestedUsers();
        $nextDate = clone $apero->getDate();
        $nextDate->modify('+7 days');
        $nextApero = new Apero($nextDate, $apero->getNumber());
        $em = $this->getDoctrine()->getManager();
        $em->persist($nextApero);
        $em->flush();
        $session->getFlashBag()->add('success', 'L\'apéro #' . $apero->getNumber() . ' a bien été annulé.');
        $mailer = $this->get('servicejf_jeudi.mailer');
        $mailer->rejectMail($interestedUsers, $apero);
        $smsInterface = $this->get('servicejf.smsinterface');
        $phoneNumbers = $smsInterface->getPhoneNumbers($interestedUsers);
        $smsInterface
            ->sendSMS($phoneNumbers, 'Désolé mais l\'apéro du ' . $apero->getDate()->format('d/m/Y') . ' n\'aura pas lieu. Rendez-vous la semaine prochaine !');
        return $this->redirectToRoute('servicejf_jeudi_admin');
    }

    public function testAction()
    {
        $smsInterface = $this->get('servicejf.smsinterface');
        var_dump($smsInterface->sendSMS(array("+33688144084"), "Hello"));
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserJeudiType::class, $user);
        $userManager = $this->get('fos_user.user_manager');
        $service = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Service')->findOneBy(array(
            'name' => 'Invités'
        ));
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $user->setService($service);
            $user->setRoles(array('ROLE_JEUDI_GUEST'));
            $user->setEnabled(true);
            $user->setManager(false);
            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', 'Ton inscription a bien été enregistrée !');
            if ($user->getPhoneNumber() != null) {
                return $this->render('ServiceJFUserBundle:Register:jeudi.html.twig', array(
                    'form' => $form->createView(),
                    'phoneToken' => true
                ));
            }
        }
        return $this->render('ServiceJFUserBundle:Register:jeudi.html.twig', array(
            'form' => $form->createView()
        ));
    }
}