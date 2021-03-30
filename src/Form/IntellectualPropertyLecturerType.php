<?php

namespace App\Form;

use App\Entity\IntellectualPropertyLecturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntellectualPropertyLecturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lecturer')
            ->add('orderNumber')
//            ->add('intellectualProperty')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IntellectualPropertyLecturer::class,
        ]);
    }
}
