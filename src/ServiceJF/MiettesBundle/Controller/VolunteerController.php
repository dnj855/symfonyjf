<?php
/**
 * User: cedriclangroth
 * Date: 15/12/2018
 * Time: 11:44
 */

namespace ServiceJF\MiettesBundle\Controller;


use ServiceJF\MiettesBundle\Entity\Volunteer;
use ServiceJF\MiettesBundle\Form\RemoveVolunteerType;
use ServiceJF\MiettesBundle\Form\VolunteerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VolunteerController extends Controller
{
    public function ManageAction()
    {
        $volunteers = $this->getDoctrine()->getRepository('ServiceJF\MiettesBundle\Entity\Volunteer')
            ->findBy(array(
                'active' => '1'
            ));
        $newVolunteer = new Volunteer();
        $removeVolunteer = new Volunteer();
        $addForm = $this->createForm(VolunteerType::class, $newVolunteer, array(
            'action' => $this->generateUrl('servicejf_miettes_add')
        ));
        $removeForm = $this->createForm(RemoveVolunteerType::class, $removeVolunteer, array(
            'action' => $this->generateUrl('servicejf_miettes_remove')
        ));
        return $this->render('ServiceJFMiettesBundle:Volunteer:manage.html.twig', array(
            'volunteers' => $volunteers,
            'addForm' => $addForm->createView(),
            'removeForm' => $removeForm->createView()
        ));
    }

    public function addAction(Request $request)
    {
        $volunteer = new Volunteer();
        $form = $this->createForm(VolunteerType::class, $volunteer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $volunteerRepository = $this->getDoctrine()->getRepository('ServiceJF\MiettesBundle\Entity\Volunteer');
            $volunteers = $volunteerRepository
                ->findBy(array(
                    'active' => '1'
                ), array(
                    'virtualCleanups' => 'ASC'
                ), 1);
            $user = $form->getData()->getUser();
            $existingVolunteer = $volunteerRepository->findOneBy(array('user' => $user));
            $em = $this->getDoctrine()->getManager();
            if ($existingVolunteer) {
                $existingVolunteer->setActive(true);
                if (empty($volunteers)) {
                    $existingVolunteer->setVirtualCleanups(0);
                } else {
                    $existingVolunteer->setVirtualCleanups($volunteers[0]->getVirtualCleanups());
                }
                $em->persist($existingVolunteer);
            } else {
                if (empty($volunteers)) {
                    $volunteer->setVirtualCleanups(0);
                } else {
                    $volunteer->setVirtualCleanups($volunteers[0]->getVirtualCleanups());
                }
                $em->persist($volunteer);
            }
            $user->setMiettes(true);
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le volontaire a bien été ajouté.');
        } else {
            $request->getSession()->getFlashBag()->add('warning', 'Une erreur s\'est produite, merci de réessayer.');
        }
        return $this->redirectToRoute('servicejf_miettes_manage');
    }

    public function removeAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $user = $request->request->get('servicejf_miettesbundle_volunteer');
        $removed = $doctrine->getRepository('ServiceJF\MiettesBundle\Entity\Volunteer')
            ->findOneBy(array(
                'id' => $user['id']
            ));
        $removed->setActive(false);
        $removed->getUser()->setMiettes(false);
        $doctrine->getManager()->persist($removed);
        $doctrine->getManager()->flush();
        $request->getSession()->getFlashBag()->add('success', 'Le volontaire a bien été retiré.');
        return $this->redirectToRoute('servicejf_miettes_manage');
    }
}