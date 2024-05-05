<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Chat; // Assuming Chat is your entity representing chat messages
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
class ChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('message', TextareaType::class)
            ->add('idsender', HiddenType::class, [
                'data' => $options['idsender'],
            ])
            ->add('idreciption', HiddenType::class, [
                'data' => $options['idreciption'],
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chat::class,
            'idsender' => null,
            'idreciption' => null,
        ]);
    }
}
