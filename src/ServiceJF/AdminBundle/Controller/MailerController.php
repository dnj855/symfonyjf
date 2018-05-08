<?php
/**
 * User: cedriclangroth
 * Date: 01/05/2018
 * Time: 09:29
 */

namespace ServiceJF\AdminBundle\Controller;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class MailerController extends Controller
{
    public function newMailAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('receiver', EntityType::class, array(
                'class' => 'ServiceJFUserBundle:User',
                'choice_label' => function ($user) {
                    return $user->getSurname() . ' ' . $user->getName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.enabled = 1')
                        ->orderBy('u.name', 'ASC');
                },
                'label' => 'Destinataire'
            ))
            ->add('object', TextType::class, array(
                'label' => 'Objet du message :'
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Texte du message :'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $mailer = $this->get('servicejf.mailer');
            $mailer->sendSimpleMail($data['receiver'], $data['message'], $data['object']);
        }

        return $this->render('ServiceJFAdminBundle:Mailer:newMail.html.twig', array(
            'form' => $form->createView()
        ));
    }
}