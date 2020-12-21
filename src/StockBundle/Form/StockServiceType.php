<?php

namespace StockBundle\Form;

use ConfigBundle\Entity\ConfigUniteMesure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockServiceType extends StockProduitType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $referenceGenere = $options['reference_genere']; //Permet de vérifier si la référence du service est à générer ou à renseigner manuellement
        parent::buildForm($builder, $options);
        $builder
//            ->add('reference', TextType::class, [
//                'attr' => [
//                    'class' => 'form-control',
//                ],
//                'required' => true,
//            ])
//            ->add('designation', TextType::class, [
//                'attr' => [
//                    'class' => 'form-control firstLetterMaj',
//                ],
//                'required' => true,
//            ])
//            ->add('prixUnitaireVente', null, [
//                'attr' => [
//                    'class' => 'form-control',
//                ],
//                'required' => true,
//            ])
            ->add('uniteMesure', EntityType::class, [
                'label' => "Unité Mesure",
                'class' => ConfigUniteMesure::class,
                'choice_label' => 'libelle',
                'required' => true,
                'placeholder' => "Sélectionnez une option ",
                'attr' => [
                    'class' => 'form-control',
//                    'class' => 'form-control chosen-select',
                ],
            ]);
        if ($referenceGenere === true) { //Si la référence du service doit être générée
            $builder->get('reference')->setDisabled(true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\StockService',
            'reference_genere' => true
 ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stockbundle_stockservice';
    }


}
