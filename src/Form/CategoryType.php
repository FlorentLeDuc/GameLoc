<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;



class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('subcat', EntityType::class, [
                'class' => Category::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
                'query_builder' => function (EntityRepository $er) {
                    
                    return $er->createQueryBuilder('c')
                        ->where('c.id < 3')
                        ->orderBy('c.id', 'ASC');
                },
            
                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => true,
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
