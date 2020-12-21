<?php

namespace TiersBundle\Form;

use ConfigBundle\Entity\ConfigPays;
use ConfigBundle\Entity\ConfigPaysLang;
use ConfigBundle\Entity\ConfigSociete;
use ConfigBundle\Repository\ConfigPaysLangRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TiersTiersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'attr' => [
                    'class' => 'form-control req',
                    'readonly' => 'readonly'
                ],
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control req allLettersMaj'],
                'required' => true,
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control req firstLetterMaj'],
                'required' => true,

            ])
            ->add('mail', EmailType::class, [
                'attr' => ['class' => 'form-control req'],
                'required' => true,
            ])
            ->add('telephone', TelType::class, [
                'attr' => ['class' => 'form-control telMask'],
                'required' => true,
            ])
            ->add('pays', EntityType::class, [
                'class' => ConfigPaysLang::class,
                'choice_label' => 'name',
                'query_builder' => static function (ConfigPaysLangRepository $configPaysLang){
                    return $configPaysLang->listePays();
                },
                'attr' => ['class' => 'form-control req chosen-select'],
                'required' => true,
            ])
            ->add('ifu', TextType::class, [
                'attr' => ['class' => 'form-control','type'=>'number'],
                'required' => false,
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TiersBundle\Entity\TiersTiers'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tiersbundle_tierstiers';
    }


}
