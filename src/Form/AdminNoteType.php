<?php

namespace App\Form;

use App\Entity\AdminNote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AdminNoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('file', FileType::class, [
                // 'label' => 'Upload an image or PDF document.',
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
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('files')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdminNote::class,
        ]);
    }
}
