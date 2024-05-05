<?php

namespace App\Form;

use App\Entity\EducationalEtablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationalEtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

     
            ->add('code')
            ->add('name')
            ->add('name_en')
            ->add('type_code')
            ->add('region_id')
            ->add('country_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EducationalEtablissement::class,
        ]);
    }
}
