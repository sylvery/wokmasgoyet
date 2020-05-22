<?php

namespace App\Form;

use App\Entity\UserTask;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    'high' => 1,
                    'medium' => 2,
                    'low' => 3
                ],
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('startDate', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'small'],
                'widget' => 'single_text'
            ])
            ->add('dueDate', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'small'],
                'widget' => 'single_text'
            ])
            ->add('completionDate', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'small'],
                'widget' => 'single_text',
                'required' => false,
                ])
            ->add('owner', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'small'],
                'class' => 'App\Entity\Member',
            ])
            ->add('taskMilestones', CollectionType::class, [
                'entry_type' => TaskMilestonesType::class,
                'allow_add' => true,
                'entry_options' => ['label' => false],
                'label_attr' => ['class' => 'small'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserTask::class,
        ]);
    }
}
