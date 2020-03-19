<?php

namespace App\Form;

use App\Entity\Context;
use App\Entity\Users;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\Mapping as ORM;



class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username' ,TextType::class,['label'=>'Identifiant'])
            ->add('email', TextType::class,['label'=>'E-mail']);

        if ($options['is_admin'] === true) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Contributeur' => 'ROLE_USER'
                ],
                'multiple' => true,
                'label'=> "Rôle"
            ]);
        }

        $builder->add('password', PasswordType::class,['label'=> 'Mot de passe'])
        ;
          /*  $builder->add('contexts', CollectionType::class, [
                'entry_type'   => ChoiceType::class,[
                    
                ]
        ]);*/

        $builder->add('contexts', CollectionType::class, array(
        'entry_type' => ContextType::class,
        'entry_options' => array('label' => false),
        'allow_add' => true,
        'allow_delete' => true
    ));


        /*$builder->add('contexts', CollectionType::class, [
            'entry_type' => ContextType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
        ]);*/


       /* $builder->add('contexts', CollectionType::class, array(
            'entry_type' => Context     ::class,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'by_reference' => false
        ));

        /*$builder->add('contexts', EntityType::class, array(
        'class' => Context::class,
        'choice_label' => 'context.nom',
        'multiple' => true,
        'expanded' => true,
        ));*/


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'is_admin' => false
        ]);
    }
}
