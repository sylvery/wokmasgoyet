<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\UserTask;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserTaskType extends AbstractType
{
    private $catrep;
    private $secu;
    public function __construct(CategoryRepository $categoryRepository, Security $security)
    {
        $this->catrep = $categoryRepository;
        $this->secu = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    'high' => 1,
                    'medium' => 2,
                    'low' => 3
                ],
                'multiple' => false,
                'expanded' => true,
                'attr' => [ 'class' => 'd-flex justify-content-between align-items-center'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choices' => $this->catrep->findBy(['createdBy' => $this->secu->getUser()]),
                'attr' => [ 'class' => 'form-control'],
                'label_attr' => [ 'class' => 'small'],
            ])
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#FFFFFF',
                ],
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
            ->add('taskMilestones', CollectionType::class, [
                'entry_type' => TaskMilestonesFullType::class,
                'allow_add' => true,
                'label' => 'Milestones',
                'entry_options' => ['label' => false, 'attr' => ['class' => 'row']],
                'label_attr' => ['class' => 'col h2'],
                'attr' => ['class' => 'col-6'],
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
