<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 20/02/2020
 * Time: 09:43
 */

namespace OperationsClientBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFacturePaiementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeActivite = $options['type_activite'];

        $builder
            ->add('paiements', CollectionType::class, [
                'entry_type' => ClientPaiementType::class,
                'allow_add' => true,
                'allow_delete' => true,
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
            'data_class' => 'OperationsClientBundle\Entity\ClientFacture',
            'type_activite' => 'article_service',
            'attr' => ['id' => 'form_paiements']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'operationsclientbundle_clientfacture';
    }
}