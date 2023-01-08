<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('numero')
            ->add('surface')
            ->add('ville')
            ->add('code_postal')
            ->add('prix_mensuel')
            ->add('prix_final')
            ->add('descriptif',TextareaType::class,[
                'attr'=>[
                    'rows' => 5, 
                    'cols' => 20
                ],
            ])
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
