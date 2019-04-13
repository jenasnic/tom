<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\User\RoleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('username')
            ->add('email')
            ->add(
                'newPassword',
                RepeatedType::class,
                [
                    'mapped' => false,
                    'required' => false,
                    'type' => PasswordType::class,
                    'constraints' => new Length(['min' => 3]),
                    'invalid_message' => 'form.user.edit.error.password',
                    'label_format' => 'form.user.edit.label.password.%name%',
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => [
                        'Administrateur' => RoleEnum::ROLE_ADMIN,
                        'Utilisateur' => RoleEnum::ROLE_USER,
                    ],
                    'multiple' => true,
                    'expanded' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'ignore_email' => false,
            'label_format' => 'form.user.edit.label.%name%',
        ]);
    }
}
