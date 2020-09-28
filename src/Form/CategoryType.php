<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('createdBy', EntityType::class, [
                'label' => 'Owner',
                'class' => Member::class,
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
