<?php

namespace StockBundle\Form;

use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Entity\ConfigTaxeGroupe;
use ConfigBundle\Repository\ConfigAgenceRepository;
use StockBundle\Entity\StockArticle;
use StockBundle\Entity\StockCategorie;
use StockBundle\Entity\StockProduit;
use StockBundle\Entity\StockService;
use StockBundle\Repository\StockCategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = new Session();
        $userID = $session->get('user_id');
        $builder
            ->add('reference', TextType::class, [
                    'label' => 'Référence',
                    'attr' => [
                        'class' => 'form-control','readonly' => 'readonly',
                    ],
                    'required' => true,
                ]
            )
            ->add('designation', TextType::class, [
                'label' => 'Désignation',
                'attr' => [
                    'class' => 'form-control firstLetterMaj',
                ],
                'required' => true,
            ])
            ->add('prixUnitaireVente', null, [
                'label' => 'Prix Unitaire Vente',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('categorie', EntityType::class, [
                'label' => "Categorie",
                'class' => StockCategorie::class,
                'choice_label' => 'libelle',
                'required' => true,
                'query_builder' => static function (StockCategorieRepository $categorieRepository) use ($userID) {
                    return $categorieRepository->listeCategorieSoc($userID);
                },
                'placeholder' => "Sélectionner une catégorie",
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('referenceInterne', TextType::class, [
                'label' => 'Réfence Interne',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('agenceId', EntityType::class, [
                'label' => 'Agence',
                'class' => ConfigAgence::class,
                'choice_label' => 'libelle',
                'required' => true,
                'query_builder' => static function (ConfigAgenceRepository $agenceRepository) use ($userID) {
                    return $agenceRepository->listeAgenceActiveSoc($userID);
                },
                'placeholder' => 'Sélectionnez une agence ',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
            ])
            ->add('taxeGroupe', EntityType::class, [
                'label' => 'Groupe de taxe',
                'class' => ConfigTaxeGroupe::class,
                'choice_label' => 'libelle',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\StockProduit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stockbundle_stockproduit';
    }


}
