<?php

namespace OperationsClientBundle\Form;

use ConfigBundle\Entity\ConfigDevise;
use ConfigBundle\Entity\ConfigEtat;
use ConfigBundle\Entity\ConfigTypeFacture;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TiersBundle\Entity\TiersClient;
use TiersBundle\Repository\TiersClientRepository;

class ClientFactureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = new Session();
        $userID = $session->get('user_id');

        $typeActivite = $options['type_activite'];
        $entityManager = $options['entity_manager'];
//        $entityManager = new EntityManager();
        $typesFactures = $entityManager->getRepository('ConfigBundle:ConfigTypeFacture')->findBy(['actif' => true]);
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Référence',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                ],
                'required' => true,
            ])
            ->add('client', EntityType::class, [
                'label' => 'Client',
                'class' => TiersClient::class,
                'choice_label' => 'nom',
                'required' => true,
                'query_builder' => static function (TiersClientRepository $tiersClientRepository) use ($userID) {
                    return $tiersClientRepository->listeTiersClientSoc($userID);
                },
                'placeholder' => 'Sélectionnez un client ',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
            ])
            ->add('dateFacture', DateType::class, [
                'label' => 'Date Facture',
                'required' => true,
                'widget' => 'single_text', 'html5' => false,
                'attr' => [
                    'class' => 'form-control toToDay datefacture',
                ],
            ])
            ->add('details', CollectionType::class, [
                'entry_type' => ClientFactureDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
//                '' =>
//                'by_reference' => false
            ])
            ->add('tauxTVA', null, [
                'label' => 'Taux TVA (%)',
                'attr' => [
                    'class' => 'form-control taux_tva',
//                    'value' => 18,
                    'readonly' => 'readonly',
                ],
                'required' => false,

            ])
            /*->add('tauxAIB', null, [
                'label' => 'Taux AIB (%)',
                'attr' => [
                    'class' => 'form-control taux_aib',
                    'value' => 0,
                    'readonly' => 'readonly',
                ],
                'required' => false,
            ])
            ->add('applicationAIB', null, [
                'label' => 'Appliquer AIB ?',
            ])*/
            ->add('devise', EntityType::class, [
                'label' => "Devise",
                'class' => ConfigDevise::class,
                'choice_label' => 'code',
                'required' => true,
                'placeholder' => "Sélectionner une devise",
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes et termes',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('totalHT', null, [
                'label' => 'Total HT',
                'attr' => [
                    'class' => 'form-control total_ht',
//                    'id' => 'totalHT',
                    'readonly' => 'readonly',
                ],
                'required' => false,

            ])
            ->add('totalTVA', null, [
                'label' => 'Total TVA',
                'attr' => [
                    'class' => 'form-control total_tva',
//                    'id' => 'totalTVA',
                    'readonly' => 'readonly',
                ],
                'required' => false,

            ])
            ->add('totalAIB', null, [
                'label' => 'Total AIB',
                'attr' => [
                    'class' => 'form-control total_aib',
//                    'id' => 'totalAIB',
                    'readonly' => 'readonly',
//                    'hidden' => 'hidden',
                ],
                'required' => false,

            ])
            ->add('totalTTC', null, [
                'label' => 'Total TTC',
                'attr' => [
                    'class' => 'form-control total_ttc',
//                    'id' => 'totalTTC',
                    'readonly' => 'readonly',
                ],
                'required' => false,
            ])
//            ->add('Etadéclaration', EntityType::class, [
//                'label' => "Devise",
//                'class' => ConfigEtat::class,
//                'choice_label' => 'Etat',
//                'required' => true,
//                'placeholder' => "Sélectionner un état ",
//                'attr' => [
//                    'class' => 'form-control',
//                    'readonly' => 'true',
//                ],
//            ])
        ;


//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            // ... adding the name field if needed
//            $facture = $event->getData();
//            $form = $event->getForm();
//            $form->add('referenceFactureOrigine', )
//        });
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
