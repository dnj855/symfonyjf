<?php

namespace ServiceJF\ChallengeDLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SetBetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bet1', TextType::class, array(
                'label' => '1.',
                'required' => false
            ))
            ->add('bet2', TextType::class, array(
                'label' => '2.',
                'required' => false
            ))
            ->add('bet3', TextType::class, array(
                'label' => '3.',
                'required' => false
            ))
            ->add('bet4', TextType::class, array(
                'label' => '4.',
                'required' => false
            ))
            ->add('bet5', TextType::class, array(
                'label' => '5.',
                'required' => false
            ))
            ->add('bet6', TextType::class, array(
                'label' => '6.',
                'required' => false
            ))
            ->add('bet7', TextType::class, array(
                'label' => '7.',
                'required' => false
            ))
            ->add('bet8', TextType::class, array(
                'label' => '8.',
                'required' => false
            ))
            ->add('bet9', TextType::class, array(
                'label' => '9.',
                'required' => false
            ))
            ->add('bet10', TextType::class, array(
                'label' => '10.',
                'required' => false
            ))
            ->add('joker', ChoiceType::class, array(
                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10'
                ),
                'expanded' => true,
                'multiple' => false,
                'choice_label' => false,
                'label' => false,
                'required' => false,
                'placeholder' => false
            ))
            ->add('saveDraft', SubmitType::class, array(
                'label' => 'Enregistrer le brouillon',
                'validation_groups' => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Enregistrer définitivement'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeDLBundle\Entity\SetBet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengedlbundle_setbet';
    }


}
