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
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('picture', FileType::class,[
                'label' => 'Choisissez une photo à uploader',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '10240k',

                    ])
                ],
            ])
            // ->add('publication_date')
            ->add('selling_price', TextType::class)
            ->add('rent_price', TextType::class)
            ->add('statement', TextType::class)
            // ->add('user', EntityType::class, [
            //     // looks for choices from this entity
            //     'class' => User::class,
            
            //     // uses the User.username property as the visible option string
            //     'choice_label' => 'username',
                    
            //         // used to render a select box, check boxes or radios
            //         'multiple' => false,
            //         'expanded' => true,
            //         ])
            
            // ->add('game', EntityType::class, [
            //     // looks for choices from this entity
            //     'class' => Game::class,
            
            //     // uses the User.username property as the visible option string
            //     'choice_label' => 'title',
                    
            //         // used to render a select box, check boxes or radios
            //         'multiple' => false,
            //         'expanded' => false,
            //         ])
            
            ->add('subcat', EntityType::class, [
                'mapped' => false,
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
                'expanded' => false,
                
                    ])
            
            
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
            
                'choice_value' => function (?Category $entity) {
                    return $entity ? $entity?->getId()."-".$entity?->getSubCat()?->getId()  : '';
                },
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
                    
                    // used to render a select box, check boxes or radios
                    'multiple' => false,
                    'expanded' => false,
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
