<?php
/**
 * User: cedriclangroth
 * Date: 25/03/2018
 * Time: 17:31
 */

namespace ServiceJF\AdminBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class curateBetType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bet1',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet2',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet3',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet4',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet5',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet6',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet7',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet8',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet9',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('bet10',EntityType::class, array(
                'class' => 'ServiceJFChallengeDLBundle:Personality',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ))
        ;
    }


}