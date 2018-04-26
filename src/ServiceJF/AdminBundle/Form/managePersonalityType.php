<?php
/**
 * User: cedriclangroth
 * Date: 22/04/2018
 * Time: 21:31
 */

namespace ServiceJF\AdminBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class managePersonalityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deathDate', DateType::class, array(
                'label' => 'Date du décès',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
            ->add('age', NumberType::class, array(
                'label' => 'Âge lors du décès'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeDLBundle\Entity\Personality'
        ));
    }

}