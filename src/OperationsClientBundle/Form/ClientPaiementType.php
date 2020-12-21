<?php

namespace OperationsClientBundle\Form;

use ConfigBundle\Entity\ConfigModePaiement;
use ConfigBundle\Entity\ConfigModeReglement;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientPaiementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePaiement', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Date Paiement',
                'required' => true,
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control date_paiement',
                ],
            ])
            ->add('modePaiement', EntityType::class, [
                'label' => 'Mode Paiement',
                'class' => ConfigModePaiement::class,
                'choice_label' => 'libelle',
                'required' => true,
                'placeholder' => 'Sélectionnez un mode ',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('montant', null, [
                'label' => 'Montant',
                'attr' => [
                    'class' => 'form-control input_montant_paiement',
                ],
                'required' => true,
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OperationsClientBundle\Entity\ClientPaiement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'operationsclientbundle_clientpaiement';
    }


}
