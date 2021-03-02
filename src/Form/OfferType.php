<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('picture', FileType::class,[
                'label' => 'Choisissez une photo à uploader',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '10240k',

                    ])
                ],
            ])
            ->add('publication_date')
            ->add('selling_price')
            ->add('rent_price')
            ->add('statement')
            ->add('user', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'username',
                    
                    // used to render a select box, check boxes or radios
                    'multiple' => false,
                    'expanded' => true,
                    ])
            
            ->add('game', EntityType::class, [
                // looks for choices from this entity
                'class' => Game::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
                    
                    // used to render a select box, check boxes or radios
                    'multiple' => false,
                    'expanded' => true,
                    ])

            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
                    
                    // used to render a select box, check boxes or radios
                    'multiple' => false,
                    'expanded' => true,
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
