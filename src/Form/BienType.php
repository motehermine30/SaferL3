<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\File\File;
class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('numero', NumberType::class)
            ->add('surface', NumberType::class)
            ->add('ville')
            ->add('code_postal')
            ->add('prix_mensuel', NumberType::class)
            ->add('prix_final',NumberType::class,[
                'label'=>'Prix Final'
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JPG ou PNG)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer',
                'download_uri' => false
            ])
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
