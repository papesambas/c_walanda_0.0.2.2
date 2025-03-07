<?php

namespace App\Form;

use App\Entity\Meres;
use App\Entity\Peres;
use App\Entity\Telephones1;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Telephones1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('peres', EntityType::class, [
                'class' => Peres::class,
                'choice_label' => 'id',
            ])
            ->add('meres', EntityType::class, [
                'class' => Meres::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Telephones1::class,
        ]);
    }
}
