<?php

namespace ConfigBundle\Form;

use ConfigBundle\Entity\ConfigAbonnement;
use ConfigBundle\Entity\ConfigBanque;
use ConfigBundle\Repository\ConfigAbonnementRepository;
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

class ConfigAbonnementSocieteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $etatEssaie = $options['etatEssaie'];


        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libelle',
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
                'label' => 'Réabonnement Automatique',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('estActif',CheckboxType::class, [
                'label' => 'Actif',
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
                'query_builder' => static function (ConfigAbonnementRepository $abonnementRepository) use ($etatEssaie)
                {
                    return $abonnementRepository->listeAbonnementSansEssai($etatEssaie);
                },
            ])

            ->add('estSupprimer', CheckboxType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('fichierPaie', FileType::class, [
                'label' => 'Fichier Paie ( Fichier PDF )',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Svp veuillez charger un document PDF valide',
                        'maxSizeMessage' => 'Fichier trop volumineux. 1Mo au maxi',
                    ])
                ],
            ])
            ->add('noteDetails', TextareaType::class, [
                'label' => 'Détails',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('decisionAdmin', TextareaType::class, [
                'label' => 'Décison Admin',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
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
        $resolver->setRequired('etatEssaie');

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
