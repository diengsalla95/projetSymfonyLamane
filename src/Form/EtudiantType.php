<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom',TextType::class,[
                'attr'=> [
                    'class' => "form-control"
                    ]
            ])
            ->add('Nom')
            ->add('email')
            ->add('dateNaissAt')
            ->add('boursier')
            ->add('Montant')
            ->add('adresse')
            ->add('chambre')
            ->add('chambre',EntityType::class, [
                'class' => chambre::class,
                'choice_label' => function($chambre){
                    return $chambre->getId();
                },
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
