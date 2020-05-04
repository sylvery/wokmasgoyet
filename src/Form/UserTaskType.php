<?php

namespace App\Form;

use App\Entity\UserTask;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'text-muted small'],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'text-muted small'],
            ])
            ->add('startDate', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'text-muted small'],
                'widget' => 'single_text'
            ])
            ->add('dueDate', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'text-muted small'],
                'widget' => 'single_text'
            ])
            ->add('completionDate', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'text-muted small'],
                'widget' => 'single_text',
                'required' => false,
            ])
            // ->add('user', EntityType::class, [
            //     'class' => 'App\Entity\AppUser',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserTask::class,
        ]);
    }
}
