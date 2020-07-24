<?php

namespace App\Form;

use App\Entity\User;
use App\Form\RoleType;
use App\Service\DevLog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            // ->add('password')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('profile')
        ;

        $builder
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    $dev = new DevLog($rolesAsArray);
                    return implode(', ', $rolesAsArray);
                },
                function ($rolesAsString) {
                    return explode(', ', $rolesAsString);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
