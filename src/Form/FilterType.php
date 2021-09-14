<?php

namespace App\Form;

use App\Entity\Filter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('popular', CheckboxType::class, [
                'label' => 'Les plus populaires',
                'required' => false,
            ])
            ->add('chrono', CheckboxType::class, [
                'label' => 'Date Chronologique',
                'required' => false,
            ])
            ->add('reverse', CheckboxType::class, [
                'label' => 'Date Antéchronologique',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
