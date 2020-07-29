<?php

namespace App\Form;

use App\Entity\TaskMilestones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskMilestonesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control'],
                'row_attr' => [ 'class' => 'mb-2'],
                'label_attr' => [ 'class' => 'small'],
            ])
            // ->add('completed')
            // ->add('task')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaskMilestones::class,
        ]);
    }
}
