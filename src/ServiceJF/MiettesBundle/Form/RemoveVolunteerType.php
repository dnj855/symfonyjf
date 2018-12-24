<?php

namespace ServiceJF\MiettesBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveVolunteerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', EntityType::class, array(
                'class' => 'ServiceJFMiettesBundle:Volunteer',
                'placeholder' => '---Choisir---',
                'label' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->where('v.active = true');
                }
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Retirer'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\MiettesBundle\Entity\Volunteer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_miettesbundle_volunteer';
    }


}
