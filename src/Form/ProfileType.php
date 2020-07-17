<?php

namespace App\Form;

use App\Entity\Profile;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('gender')
            ->add('address')
            ->add('country')
            ->add('nationality')
            ->add('hasPassport')
            ->add('passportScan')
            ->add('curriculumVitae')
            ->add('picture')
            ->add('currentLocation')
            ->add('dateOfBirth', BirthdayType::class, [
                'widget' => 'single_text'
            ])
            ->add('placeOfBirth')
            ->add('isAvailable')
            ->add('experience')
            ->add('description')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('deletedAt')
            // ->add('adminNote')
            ->add('jobSector')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
