<?php

namespace ServiceJF\ChallengeCHBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GameCreateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('scoreHome')
            ->remove('scoreAway');
    }

    public function getParent()
    {
        return GameType::class;
    }
}