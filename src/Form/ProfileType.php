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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

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
            ->add('passportScan', FileType::class, [
                // 'label' => 'Passport scan : Upload an image or PDF document.',
                // 'data_class' => null
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' =>  '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/*'
                        ],
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). '
                            . 'Allowed maximum size is {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Please upload an image or PDF document. '
                            . 'The mime type of the file is invalid ({{ type }}). '
                            . 'Allowed mime types are {{ types }}.',
                    ])
                ],
                'attr' => [
                    'class' => 'form-inline',
                    'placeholder' => 'Select an image or PDF document.'
                ]
            ])
            // ->add(
            //     'existingPassportScan',
            //     UrlType::class,
            //     [
            //         'label' => 'Current file',
            //         'required' => false,
            //         'mapped' => false
            //     ]
            // )
            ->add('curriculumVitae', FileType::class, [
                // 'label' => 'CV : Upload an image or PDF document.',
                // 'data_class' => null
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' =>  '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). '
                            . 'Allowed maximum size is {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Please upload an image or PDF document. '
                            . 'The mime type of the file is invalid ({{ type }}). '
                            . 'Allowed mime types are {{ types }}.',
                    ])
                ],
                'attr' => [
                    'class' => 'form-inline',
                    'placeholder' => 'Select an image or PDF document.'
                ]
            ])
            ->add('picture', FileType::class, [
                // 'label' => 'Profile picture : Upload an image or PDF document.',
                // 'data_class' => null
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' =>  '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/*'
                        ],
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). '
                            . 'Allowed maximum size is {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Please upload an image or PDF document. '
                            . 'The mime type of the file is invalid ({{ type }}). '
                            . 'Allowed mime types are {{ types }}.',
                    ])
                ],
                'attr' => [
                    'class' => 'form-inline',
                    'placeholder' => 'Select an image or PDF document.'
                ]
            ])
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
            $builder->add('adminNote', AdminNoteType::class, []);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
