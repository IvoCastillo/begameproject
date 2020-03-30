<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            // Set various options for the radio buttons
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'rookie' => 'ROLE_ROOKIE',
                    'advanced' => 'ROLE_ADVANCED',
                ],
                'choice_label' => function($choice) {
                    // only way to get proper labels on the radio buttons
                    if($choice === 'ROLE_ROOKIE') {
                        return 'Rookie';
                    } else {
                        return 'Advanced';
                    }
                },
                'mapped' => false,
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('randomField', TextType::class, array(
                "mapped" => false,
                "label" => false,
                "required" => false,
//                'constraints' => [
//                    new UniqueEntity([
//                        'fields' => ['teamName', 'teamName'],
//                        'errorPath' => 'port',
//                        'message' => 'This port is already in use on that host.',
//                        ]),
//                    ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
