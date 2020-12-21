<?php

namespace ConfigBundle\Form;

use ConfigBundle\Entity\ConfigPaysLang;
use ConfigBundle\Repository\ConfigPaysLangRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigAgenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null, [
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                ],
                'required' => false,
            ])->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
//            ->add('created')
            ->add('numeroMCF', TextType::class, [
                'label' => 'Numéro MCF',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('portServeur', TextType::class, [
                'label' => 'PS',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                ],
                'required' => false,
            ])
            ->add('paysSise', EntityType::class, [
                'label'=>'Pays',
                'class' => ConfigPaysLang::class,
                'choice_label' => 'name',
                'query_builder' => static function (ConfigPaysLangRepository $configPaysLang){
                    return $configPaysLang->listePays();
                },
                'attr' => ['class' => 'form-control chosen-select'],
                'required' => true,
            ])
            /*
            ->add('estSupprimer', CheckboxType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])*/
        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ConfigBundle\Entity\ConfigAgence',

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
