<?php

namespace ServiceJF\ChallengeFGBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PunchlineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('punchline', TextareaType::class, array(
                'label' => 'label.punchline'
            ))
            ->add('postDate', DateType::class, array(
                'label' => 'label.postDate',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'button.submit'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeFGBundle\Entity\Punchline'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengefgbundle_punchline';
    }


}
