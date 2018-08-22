<?php
/**
 * User: cedriclangroth
 * Date: 02/08/2018
 * Time: 18:42
 */

namespace ServiceJF\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SMSController extends Controller
{
    public function ConfirmAction(Request $request)
    {
        if ($request->getMethod() != 'POST') {
            throw new NotFoundHttpException('La page ne peut pas être affichée.');
        }
        return $this->redirectToRoute('servicejf_SMS_confirm_token', array(
            'token' => $request->get('phoneToken')
        ));
    }

    public function ConfirmTokenAction($token, Session $session)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if ($user->getPhoneToken() == $token) {
            $user->setVerifiedNumber(true);
            $session->getFlashBag()->add('success', 'Le numéro de téléphone a bien été validé.');
            $this->get('fos_user.user_manager')->updateUser($user);
        } else {
            $session->getFlashBag()->add('warning', 'La vérification du numéro de téléphone a échoué.');
        }
        return $this->redirectToRoute('servicejf_homepage');
    }
}