<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 18/03/2020
 * Time: 11:57
 */

namespace UserBundle\Form;

use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Entity\ConfigSociete;
use ConfigBundle\Form\ConfigSocieteType;
use ConfigBundle\Repository\ConfigAgenceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType2 extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
// Pour les super admin afin qu'ils ajoute des admin ou roles
        $builder
            ->add('agence', EntityType::class, [
                'label' => 'Agence',
                'class' => ConfigAgence::class,
                'choice_label' => 'libelle',
                'required' => false,
                'placeholder' => 'Sélectionnez une agence ',
                'attr' => [
                    'class' => 'form-control chosen-select',
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control allLettersMaj',
                ],
                'required' => false,
            ])
            ->add('prenoms', TextType::class, [
                'label' => 'Prénom(s)',
                'attr' => [
                    'class' => 'form-control firstLetterMaj',
                ],
                'required' => false,
            ])
            ->add('roles', ChoiceType::class,
                [
                    'label' => 'Roles',
                    'attr' => [
                        'class' => 'form-control chosen-select',
                    ],
                    'choices' =>
                        [
                            'ROLE_ADMIN' => 'ROLE_ADMIN',
                            'ROLE_CLT_ADMIN' => 'ROLE_CLT_ADMIN',
                            'ROLE_FNS_ADMIN' => 'ROLE_FNS_ADMIN',
                            'Controleur' => 'ROLE_CONTROLEURUR',
                            'Caissier' => 'ROLE_CAISSE',
                            'Vendeur' => 'ROLE_VENDEUR',
                            'Comptable' => 'ROLE_COMPTABLE',
                            'Visiteur' => 'ROLE_VISITEUR',
                        ],
                    'required' => false,
                    'multiple' => true,
                ]

            );

//        $builder->add('last_name');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }



    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'user' => null
        ));
    }

}