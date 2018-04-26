<?php
/**
 * User: cedriclangroth
 * Date: 26/11/2017
 * Time: 20:08
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\UserBundle\Entity\User;
use ServiceJF\UserBundle\Form\EnableUserType;
use ServiceJF\UserBundle\Form\UserCreateType;
use ServiceJF\UserBundle\Form\UserEditPasswordType;
use ServiceJF\UserBundle\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function createAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $this->createForm(UserCreateType::class, $user);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été créé.');
            return $this->redirectToRoute('servicejf_admin_user_create');
        }
        return $this->render('ServiceJFAdminBundle:users:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array(
            'id' => $id
        ));
        if (!$user) {
            throw new NotFoundHttpException('L\'utilisateur demandé n\'existe pas.');
        }
        $form = $this->createForm(UserEditType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if ($request->request->get('ROLE_CSS')) {
                $user->addRole('ROLE_CSS');
            } elseif ($request->request->get('UNSET_ROLE_CSS')) {
                $user->removeRole('ROLE_CSS');
            }
            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été modifié.');
            return $this->redirectToRoute('servicejf_admin_home');
        }
        return $this->render('ServiceJFAdminBundle:users:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    public function editPasswordAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array(
            'id' => $id
        ));

        if (!$user) {
            throw new NotFoundHttpException('L\'utilisateur demandé n\'existe pas.');
        }

        $form = $this->createForm(UserEditPasswordType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été modifié.');
            return $this->redirectToRoute('servicejf_admin_home');
        }
        return $this->render('ServiceJFAdminBundle:users:editpassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    public function disableAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array(
            'id' => $id));
        if (!$user) {
            throw new NotFoundHttpException('L\'utilisateur demandé n\'existe pas.');
        }
        $form = $this->createForm(EnableUserType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été modifié.');
            return $this->redirectToRoute('servicejf_admin_home');
        }
        return $this->render('ServiceJFAdminBundle:users:disable.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}