<?php

namespace App\Form;


use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('subject')
            ->add('user_id')
            ->add('prix')
            ->add('imageFileName', FileType::class,[
                'required' =>false,
                'mapped' =>false,
               'constraints' =>[
                new Image(['maxSize' =>'5000k'])
               ]

            ])
            ->add('from_date')
            ->add('to_date')
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'Education and formation' => '#0000FF',
                    'Arts and Culture' => '#008000',
                    'Social  ' => '#FF0000',
                    'other event' => '#800080',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
