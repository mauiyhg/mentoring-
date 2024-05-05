<?php

namespace App\Form;



use Symfony\Component\Form\Extension\Core\Type\TextType;
// ... (autres imports)
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image; 

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail'
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom'
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse'
            ])
            ->add('zipcode', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code postal'
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville'
            ])
            ->add('imageFileName', FileType::class,[
                'required' =>false,
                'mapped' =>false,
               'constraints' =>[
                new Image(['maxSize' =>'5000k'])
               ]

            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'En m\'inscrivant à ce site j\'accepte...'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Mentor' => 'MENTOR',
                    
                    'Mentee' => 'MENTEE',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Roles',
            ])

            ->add('domaine', ChoiceType::class, [
                'choices' => [
                    'Professional Development' => 'Professional Development',
                    'Education' => 'Education',
                    ' computer science' => ' computer science',
                    'Entrepreneurship' => 'Entrepreneurship',
                    'Technology' => 'Technology',
                    'Diversity and Inclusion' => 'Diversity and Inclusion',
                    'web development' => 'web development',
                    'Leadership and Management' => 'Leadership and Management',
                    'Arts and Creative Industries' => 'Arts and Creative Industries',
                    'Healthcare and Wellness' => 'Healthcare and Wellness',
                    'STEM (Science, Technology, Engineering, and Mathematics)' => 'STEM (Science, Technology, Engineering, and Mathematics)',
                    'Social Impact and Nonprofits' => 'Social Impact and Nonprofits',
                    ' Business' => ' Business'
                    
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'domaine'
            ])
            
         
            ->add('profile', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'profile',
                'required' => false,
            ])
            ->add('exprience', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'exprience',
                'required' => false,
            ])
          

            ->add('competence', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'competence',
                'required' => false,
            ])
       
            
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
