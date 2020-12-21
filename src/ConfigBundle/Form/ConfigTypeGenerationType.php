<?php

namespace ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigTypeGenerationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', null, [
            'attr' => [
                'class' => 'form-control',
                'readonly' => 'readonly',
            ],
            'required' => false,
        ])->add('libelle', TextType::class, [
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('codeSociete', TextType::class, [
            
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('codeAgence', TextType::class, [
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('codeFournisseur', TextType::class, [
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('codeClient', TextType::class, [
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('referenceArticle', TextType::class, [
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('referenceService', TextType::class, [
            
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('referenceApprovisionnement', TextType::class, [
            
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('referenceFacture', TextType::class, [
            
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ])->add('referenceInventaire', TextType::class, [
            
            'attr' => [
                'class' => 'form-control allLettersMaj',
            ],
            'required' => false,
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ConfigBundle\Entity\ConfigTypeGeneration'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'configbundle_configtypegeneration';
    }


}
