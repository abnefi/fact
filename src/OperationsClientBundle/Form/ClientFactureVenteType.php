<?php

namespace OperationsClientBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFactureVenteType extends ClientFactureType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('dateReglement', DateType::class, [
                'label' => 'Date Règlement Probable',
                'required' => true,
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control fromToDay datereglement',
                ],

            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setDefaults(array(
            'data_class' => 'OperationsClientBundle\Entity\ClientFactureVente',
            'type_activite' => 'article_service'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'operationsclientbundle_clientfacturevente';
    }


}
