<?php
/**
 * User: cedriclangroth
 * Date: 28/11/2017
 * Time: 10:58
 */

namespace ServiceJF\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnableUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('enabled', ChoiceType::class, array(
                'expanded' => true,
                'multiple' => false,
                'label' => false,
                'choices' => array(
                    'Actif' => true,
                    'Inactif' => false
                )
            ))
        ->add('save', SubmitType::class, array(
            'label' => 'Modifier'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_userbundle_user';
    }
}