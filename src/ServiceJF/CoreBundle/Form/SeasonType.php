<?php

namespace ServiceJF\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateBegin', DateType::class, array(
                'widget' => 'choice',
                'label' => 'Début',
                'months' => array(7),
                'days' => array(15)
            ))
            ->add('dateEnd', DateType::class, array(
                'widget' => 'choice',
                'label' => 'Fin',
                'months' => array(7),
                'days' => array(14)
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Créer'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\CoreBundle\Entity\Season'
        ));
    }


}
