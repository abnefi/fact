<?php

namespace OperationsClientBundle\Form;

use ConfigBundle\Entity\ConfigUniteMesure;
use StockBundle\Entity\StockArticle;
use StockBundle\Entity\StockProduit;
use StockBundle\Repository\StockProduitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFactureDetailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = new Session();
        $userID = $session->get('user_id');
        $builder
            ->add('aibDeductible', CheckboxType::class, [
                'label' => 'Appliquer AIB',
            ])
            ->add('tauxAIB', null, [
                'label' => 'Taux AIB',
                'attr' => [
                    'class' => 'form-control aib',
                ],
                'required' => false,
            ])
            ->add('taxeDeSejour', null, [
                'label' => 'Taxe de Sejour',
                'attr' => [
                    'class' => 'form-control taxe-de-sejour',
                ],
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Selectionnez un type' => null,
                    'Article' => 'article',
                    'Service' => 'service'
                ],
                'mapped' => false,
                'label' => 'Type',
                'attr' => [
                    'class' => 'form-control chosen-select select_type_produit'
                ]
            ])
            ->add('produit', EntityType::class, [
                'label' => 'Désignation',
                'class' => StockProduit::class,
                'choice_label' => 'designation',
                'required' => true,
                'query_builder' => static function (StockProduitRepository $produitRepository) use ($userID) {
                    return $produitRepository->listeProduitSoc($userID);
                },
                'placeholder' => 'Sélectionnez un élément',
                'attr' => [
                    'class' => 'form-control chosen-select select_article',
                ],
            ])
            ->add('uniteMesure', EntityType::class, [
                'label' => 'Unité Mesure',
                'class' => ConfigUniteMesure::class,
                'choice_label' => 'libelle',
                'required' => true,
//                'placeholder' => "Sélectionnez une option",
                'attr' => [
                    'class' => 'form-control unite_mesure',
                ],
            ])
            ->add('quantite', IntegerType::class, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'form-control quantite_produit',
                    'step' => 'any',
                ],
                'required' => true,
            ])
            ->add('prixVenteUnitaire', IntegerType::class, [
                'label' => 'PU HT',
                'attr' => [
                    'class' => 'form-control prix_vente_unitaire',
                    'step' => 'any',
                    'readonly' => 'true',
                    'data-taxespecifique' => 0,
//                    'data-id' => 0,
                ],
                'required' => true,
            ])
            /*->add('tauxRemise', IntegerType::class, [
                'label' => 'Remise (%)',
                'attr' => [
                    'class' => 'form-control tauxremise',
                    'value' => 0,
                    'step' => 'any',
                ],
                'required' => false,
            ])*/
//            ->add('tvaDeductible', null, [
//                'label' => 'TVA Déductible',
//                'attr' => [
//                    'class' => 'form-control',
//                ],
//            ])
//            ->add('tauxTVA', null, [
//                'label' => 'Taux TVA',
//                'attr' => [
//                    'class' => 'form-control',
//                ],
//                'required' => false,
//            ])
//            ->add('taxable', null, [
//                'label' => 'Taxable ?',
//            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control description',
                    'placeholder' => "Entrez une description de l'article"
                ],
                'required' => false,
            ])
            /*->add('raisonTaxeSpec', TextType::class, [
                'label' => 'Motif',
                'attr' => [
                    'class' => 'form-control motif',
                    'placeholder' => "Motif de la taxe spécifique"
                ],
                'required' => false,
            ])*/
            ->add('hasTaxeSpecifique', CheckboxType::class, [
                'label' => 'Taxe spécifique ?',
                'attr' => [
                    'class' => 'checkbox_taxe_specifique',
                ],
            ])
            ->add('taxeSpecifique', null, [
                'label' => 'Taxe Spécifique',
                'attr' => [
                    'class' => 'form-control taxespecifique',
                    'placeholder' => "Entrez le taux"
                ],
                'required' => false,
            ])
            ->add('descriptionTaxeSpecifique', TextType::class, [
                'label' => 'Motif',
                'attr' => [
                    'class' => 'form-control textarea_description_taxe_specifique',
                    'placeholder' => "Entrez une description"
                ],
                'required' => false,
            ])
            ->add('changementPrixUnitaireTTC', null, [
                'label' => 'Changement PU TTC ?',
                'attr' => [
                    'class' => 'checkbox_prix_origine',
                ],
            ])
            ->add('dernierPrixOrigine', null, [
                'label' => 'Dernier Prix Origine',
                'required' => false,
                'attr' => [
                    'class' => 'form-control dernier_prix_origine',
//                    'placeholder' => "Entrez le dernier prix",
                    'readonly' => 'true',
                ],
            ])
            ->add('descriptionPrixOrigine', TextareaType::class, [
                'label' => 'Description de la cause du changement',
                'attr' => [
                    'class' => 'form-control textarea_description_taxe_prix_origine',
                    'placeholder' => "Entrez une description"
                ],
                'required' => false,
            ]);
//        $builder->get('produit')->setAttribute('class')
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OperationsClientBundle\Entity\ClientFactureDetail',
            'type_activite' => 'article_service'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'operationsclientbundle_clientfacturedetail';
    }


}
