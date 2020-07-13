<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Batiment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('numChambre')
        ->add('typeChambre', ChoiceType::class, [
            'choices'  => [
                'simple' => 'simple',
                'double' => 'double',
            ],
        ])
        ->add('batiment',EntityType::class, [
            'class' => batiment::class,
            'choice_label' => function($batiment){
                return $batiment->getnomBatiment();
            },
        ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
