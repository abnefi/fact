<?php

namespace ConfigBundle\Form;

use ConfigBundle\Entity\ConfigAbonnement;
use ConfigBundle\Entity\ConfigBanque;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ConfigAbonnementSocieteType2 extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
            'label' => 'Description',
            'attr' => [
                'class' => 'form-control',
            ],
            'required' => true,])

            ->add('debutAbonnement', DateType::class, [
                'label' => 'Debut',
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control toToDay',
                ],
                'required' => false,

            ])
            ->add('finAbonnement', DateType::class, [
                'label' => 'Fin',
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control fromToDay',
                ],
                'required' => false,

            ])
            ->add('reabonnementAuto',CheckboxType::class, [
                'label' => 'Automatique',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('typeAbonnement',EntityType::class, [
                'label'=>'Type Abonnement',
                'class' => ConfigAbonnement::class,
                'placeholder' => '',
                'choice_label' => 'libelle',
                'attr' => ['class' => 'form-control chosen-select'],
                'required' => true,
            ])

            ->add('estSupprimer', CheckboxType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('noteDetails', TextareaType::class, [
                'label' => 'Détails',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('decisionAdmin', TextareaType::class, [
                'label' => 'Observation Admin',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('banque', EntityType::class, [
                'label' => 'Banque',
                'class' => ConfigBanque::class,
                'choice_label' => 'libelle',
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('duree', NumberType::class, [
                'label' => 'Durée',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ConfigBundle\Entity\ConfigAbonnementSociete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'configbundle_configabonnementsociete';
    }


}
