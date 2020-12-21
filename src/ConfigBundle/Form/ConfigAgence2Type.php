<?php

namespace ConfigBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigAgence2Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])

            ->add('numeroMCF', TextType::class, [
                'label' => 'Numéro MCF',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])

            ->add('code', null, [
                'label' => "Code",
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly'
                ],
            ])

            ->add('societe', ConfigSocieteType::class)
        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ConfigBundle\Entity\ConfigAgence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'configbundle_configagence';
    }


}
