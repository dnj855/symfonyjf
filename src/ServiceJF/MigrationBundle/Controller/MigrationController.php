<?php
/**
 * User: cedriclangroth
 * Date: 10/12/2017
 * Time: 09:26
 */

namespace ServiceJF\MigrationBundle\Controller;


use ServiceJF\MigrationBundle\Form\UserMigrateType;
use ServiceJF\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MigrationController extends Controller
{
    public function SetAdminAction($username)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $userManager->updateUser($user);
        return $this->redirectToRoute('servicejf_homepage');
    }

    public function FirstStepAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($request->request->get('username'));
            if (!$user) {
                $request->getSession()->getFlashBag()->add('warning', 'L\'utilisateur ' . $request->request->get('username') . ' n\'existe pas.');
                return $this->redirectToRoute('servicejf_migration_step1');
            } elseif ($user->getEmail()) {
                $request->getSession()->getFlashBag()->add('warning', $user->getSurname() . ' : tu peux te connecter.');
                return $this->redirectToRoute('fos_user_security_login');
            } else {
                $user->setEnabled(1);
                $user->setRoles(array('ROLE_USER'));
                $user->setUsername($request->request->get('username'));
                $userManager->updateUser($user);
                return $this->redirectToRoute('servicejf_migration_step2', array(
                    'username' => $user->getUsername()
                ));
            }
        }
        return $this->render('ServiceJFMigrationBundle:migration:step1.html.twig');
    }

    public function SecondStepAction(Request $request, $username)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        if (!$user) {
            throw new NotFoundHttpException('L\'utilisateur ' . $username . ' n\'existe pas.');
        } elseif ($user->getEmail()) {
            $request->getSession()->getFlashBag()->add('warning', $user->getSurname() . ' : tu peux te connecter.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $form = $this->createForm(UserMigrateType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $user->setEnabled(1);
            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', 'C\'est tout bon, tu peux te connecter !');
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('ServiceJFMigrationBundle:migration:step2.html.twig', array(
            'form' => $form->createView()
        ));
    }
}