<?php

namespace StockBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TiersBundle\Entity\TiersFournisseur;
use TiersBundle\Repository\TiersFournisseurRepository;

class StockApprovisionnementType extends AbstractType
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
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                ],
                'required' => true,
            ])
            ->add('dateReception', DateType::class, [
                'label' => 'Date Réception',
                'required' => true,
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control date',
                ],
            ])
            ->add('fournisseur', EntityType::class, [
                'label' => 'Fournisseur',
                'class' => TiersFournisseur::class,
                'choice_label' => 'nom',
                'required' => true,
                'query_builder' => static function (TiersFournisseurRepository $fournisseurRepository) use ($userID) {
                    return $fournisseurRepository->listeFournisseurSoc($userID);
                },
                'placeholder' => 'Sélectionnez un fournisseur ',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
            ])
            ->add('details', CollectionType::class, [
                'entry_type'   => StockApprovisionnementDetailType::class,
                'allow_add'    => true,
                'allow_delete' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\StockApprovisionnement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stockbundle_stockapprovisionnement';
    }


}
