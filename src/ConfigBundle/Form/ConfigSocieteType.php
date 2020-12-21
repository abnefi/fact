<?php

namespace ConfigBundle\Form;

use ConfigBundle\Entity\ConfigBanque;
use ConfigBundle\Entity\ConfigDevise;
use ConfigBundle\Entity\ConfigPays;
use ConfigBundle\Entity\ConfigPaysLang;
use ConfigBundle\Entity\ConfigTypeActivite;
use ConfigBundle\Repository\ConfigDeviseRepository;
use ConfigBundle\Repository\ConfigPaysLangRepository;
use OperationsClientBundle\Form\ClientFactureDetailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\ChoiceListFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;

class ConfigSocieteType extends AbstractType
{

    private function getFunction() {
        $url = 'https://module-prospect.africabourse.com/web/app_dev.php/send/fonction/list';

        $headers = [
            'Content-type' => 'application/json'
        ];
        $options = array(
            'timeout' => 100,
            'connect_timeout' => 100,
        );
        $response = \Requests::get($url, $headers, $options);
        $data = $response->body;
        $choices = [];
        $data = json_decode($data, false);
        foreach ($data as $datum) {
            $choices[$datum->fonction] = $datum->fonction;
        }
        return $choices;
    }

    private function getFormJuridique() {
        $url = 'https://module-prospect.africabourse.com/web/app_dev.php/get/liste-forme-juridique';

        $headers = [
            'Content-type' => 'application/json'
        ];
        $options = array(
            'timeout' => 100,
            'connect_timeout' => 100,
        );
        $response = \Requests::get($url, $headers, $options);
        $data = $response->body;
        $choice = [];
        $data = json_decode($data,false);
        foreach ($data as $datum) {
            $choice[$datum->formeJuridique] = $datum->formeJuridique;
        }
        return $choice;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = $this->getFunction();
        $choice = $this->getFormJuridique();

        $builder
            ->add('banque', EntityType::class, [
                'label' => 'Banque',
                'class' => ConfigBanque::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Selectionner votre banque',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('raisonSociale', TextType::class, [
                    'label' => 'Nom commercial',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('email', null, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly'
                ],
//                'required' => false,
            ])
            ->add('registreCommerce', TextType::class, [
                'label' => 'N° Registre de commerce',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('ifu', IntegerType::class, [
                'label' => 'N° IFU',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '-0000000000009',
                    'max' => '9999999999999'
                ],
                'required' => true,
            ])
            ->add('fonctionRepresentant', ChoiceType::class, [
                'label' => 'Fonction',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
                'choices' => $choices,
                'required' => false,
            ])
            ->add('formeJuridique', ChoiceType::class, [
                'label' => 'Forme Juridique',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
                'choices' => $choice,
                'required' => false,
            ])

            ->add('capital', TextType::class, [
                'label' => 'Capital',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])

            ->add('pays', EntityType::class, [
                'label'=>'Pays',
                'class' => ConfigPaysLang::class,
                'choice_label' => 'name',
                'query_builder' => static function (ConfigPaysLangRepository $configPaysLang){
                    return $configPaysLang->listePays();
                },
                'attr' => ['class' => 'form-control chosen-select'],
                'required' => true,
            ])
            ->add('rib', TextType::class, [
                'label' => 'N°compte bancaire',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('assujetiTva', ChoiceType::class, [
                'label' => 'Assujeti à la TVA ?',
                'choices' => array(
                    'Oui' => 1,
                    'Non' => 0,
                ),
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Faite un choix',
                'required' => false,
            ])
            ->add('exportation', CheckboxType::class, [
                'label' => 'Assujeti à l\'exportation',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('typeActivite', EntityType::class, [
                'label' => "Type d'activité",
                'class' => ConfigTypeActivite::class,
                'choice_label' => 'libelle',
                'required' => true,
                'placeholder' => "Sélectionner un type d'activité ",
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('devise', EntityType::class, [
                'label' => "Devise",
                'class' => ConfigDevise::class,
                'required' => true,
                'placeholder' => "Sélectionner une devise ",
                'attr' => [
                    'class' => 'form-control',
                ],
                'empty_data' => static function (ConfigDeviseRepository $configDeviseRepository){
                    return $configDeviseRepository->getdevise();
                },
            ])
            ->add('code', null, [
                'label' => "Code",
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly'
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('siteWeb', TextType::class, [
                'label' => 'Site Web',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "https://monsite.com",
                ],
                'required' => false,
            ])
            ->add('typeEntreprise', ChoiceType::class, array(
                'choices' => array(
                    'Sociétée' => 'societe',
                    'Etablissement' => 'etablisement',
                    'Entreprise individuelle' => 'entrepriseIndividuelle',
                ),
                'expanded' => true,
            ))
            ->add('estProfessionLiberale', ChoiceType::class, array(
                'choices' => array(
                    'Oui' => 1,
                    'Non' => 0,
                ),
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Faite un choix',
                'required' => false,
            ))
            ->add('ifuFile', FileType::class, [
                'label' => 'Ifu ( Fichier PDF )',
                'attr' => [
                    'accept' => '.pdf',
                ],

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Svp veuillez charger un document PDF valide',
                        'maxSizeMessage' => 'Fichier trop volumineux. 1Mo au maxi',
                    ])
                ],
            ])
            ->add('registreFile', FileType::class, [
                'label' => 'Registre de commerce( Fichier PDF )',
                'attr' => [
                    'accept' => '.pdf',
                ],

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Svp veuillez charger un document PDF valide',
                        'maxSizeMessage' => 'Fichier trop volumineux. 1Mo au maxi',
                    ])
                ],
            ])
        ;
        $builder->get('typeEntreprise')->setData('societe');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ConfigBundle\Entity\ConfigSociete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'configbundle_configsociete';
    }


}
