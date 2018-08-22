<?php
/**
 * User: cedriclangroth
 * Date: 04/06/2018
 * Time: 18:58
 */

namespace ServiceJF\ChallengeCSSBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class GameEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('gameNumber')
            ->remove('home')
            ->remove('opponent')
            ->remove('date')
            ->add('submit', SubmitType::class, array(
                'label' => 'Enregistrer'
            ));
    }

    public function getParent()
    {
        return GameType::class;
    }
}