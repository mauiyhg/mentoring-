<?php

namespace App\Form;

use App\Entity\Activty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image; 
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ActivtyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('subject')
            ->add('text')
            ->add('imageFileName', FileType::class,[
                'required' =>false,
                'mapped' =>false,
               'constraints' =>[
                new Image(['maxSize' =>'5000k'])
               ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activty::class,
        ]);
    }
}
