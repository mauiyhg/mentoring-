<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('lastname')
            ->add('firstname')
            ->add('address')
            ->add('zipcode')
            ->add('city');
        
            
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $user = $event->getData();
            if (in_array(['MENTOR','MENTEE'], $user->getRoles())) {
                $form->add('domaine', TextType::class, [
                    'required' => false,
                  
                ]);
                }
           
            if (in_array('MENTOR', $user->getRoles())) {
                $form->add('profile', TextareaType::class, [
                    'required' => false,
                  
                ]);
                $form->add('exprience', TextareaType::class, [
                    'required' => false,
                ]);
                $form->add('competence', TextareaType::class, [
                    'required' => false,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
