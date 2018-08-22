<?php

namespace ServiceJF\JeudiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AperoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', TextareaType::class, array(
                'label' => 'Adresse de l\'apéro :'
            ))
            ->add('displayDate', TimeType::class, array(
                'input' => 'datetime',
                'widget' => 'choice',
                'label' => 'Heure de la réservation :'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\JeudiBundle\Entity\Apero'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_jeudibundle_apero';
    }


}
