<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 24/02/2020
 * Time: 17:15
 */

namespace OperationsClientBundle\Form;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use ConfigBundle\Entity\ConfigDevise;
use ConfigBundle\Entity\ConfigTypeFacture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TiersBundle\Entity\TiersClient;


class   ClientFactureAvoirType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeActivite = $options['type_activite'];
        $entityManager = $options['entity_manager'];
        $typesFactures = $entityManager->getRepository('ConfigBundle:ConfigTypeFacture')->findBy(['actif' => true]);
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Référence',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'true',
                ],
                'required' => true,
            ])
//            ->add('client', EntityType::class, [
//                'label' => 'Client',
//                'class' => TiersClient::class,
//                'choice_label' => 'nom',
//                'required' => true,
//                'placeholder' => 'Sélectionnez un client ',
//                'attr' => [
//                    'class' => 'form-control chosen-select',
//                ],
//            ])
            ->add('dateFacture', DateType::class, [
                'label' => 'Date Facture',
                'required' => true,
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control date',
                    'readonly' => 'true',
                ],
            ])
            ->add('dateReglement', DateType::class, [
                'label' => 'Date Règlement',
                'required' => true,
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control date',
                    'readonly' => 'true',
                ],
            ])
//            ->add('details', CollectionType::class, [
//                'entry_type' => ClientFactureDetailType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
////                '' =>
////                'by_reference' => false
//            ])
            ->add('tauxTVA', null, [
                'label' => 'Taux TVA',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'true',
                ],
                'required' => false,
            ])
            /*->add('tauxAIB', null, [
                'label' => 'Taux AIB',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'true',
                ],
                'required' => false,
            ])*/
            ->add('devise', EntityType::class, [
                'label' => "Devise",
                'class' => ConfigDevise::class,
                'choice_label' => 'code',
                'required' => true,
                'placeholder' => "Sélectionner une devise ",
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'true',
                ],
            ])
;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setDefaults(array(
            'data_class' => 'OperationsClientBundle\Entity\ClientFacture',
            'type_activite' => 'article_service'
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