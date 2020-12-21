<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 13/03/2020
 * Time: 17:43
 */

namespace StockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockInventaireEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('referenceInventaire', TextType::class, [
//            'label' => "Référence de l'inventaire",
//            'attr' => [
//                'class' => 'form-control',
//            ],
//            'required' => true,
//        ])
            ->add('details', CollectionType::class, [
                'entry_type' => StockInventaireDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
//                '' =>
//                'by_reference' => false
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\StockInventaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stockbundle_stockinventaire';
    }
}