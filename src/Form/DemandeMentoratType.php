<?php

namespace App\Form;

use App\Entity\DemandeMentorat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeMentoratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => 'Your message for the mentor:'
            ])
            ->add('id_mentee', HiddenType::class, [
                'data' => $options['id_mentee'],
            ])
            ->add('id_mentor', HiddenType::class, [
                'data' => $options['id_mentor'],
            ])
           
            ->add('offer', HiddenType::class, [
                'data' => $options['offer'],
            ]);
           
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeMentorat::class,
            'id_mentee' => null,
            'id_mentor' => null,
            'offer' => null,
        ]);
    }
}