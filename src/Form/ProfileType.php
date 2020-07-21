<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\JobSector;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    protected $auth;
    public function __construct(AuthorizationCheckerInterface $auth)
    {
        $this->auth = $auth;
    }

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
                'widget' => 'single_text',
                'required' => 'false'
            ])
            ->add('placeOfBirth')
            ->add('isAvailable')
            ->add('experience')
            ->add('description')
            ->add('jobSector', EntityType::class, [
                'class' => JobSector::class,
                'placeholder' => 'Choose a Job Sector',
                'required' => false
            ]);
        // ->add('createdAt')
        // ->add('updatedAt')
        // ->add('deletedAt')

        if ($this->auth->isGranted('ROLE_ADMIN')) {
            $builder->add('adminNote', AdminNoteType::class, [
                    'attr' => ['class' => 'form-inline']
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
