<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 20/03/2020
 * Time: 12:09
 */

namespace UserBundle\Form;

use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Repository\ConfigAgenceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $role = $options['role'];

        $session = new Session();
        $userID = $session->get('user_id');

        if (!$role) {
            $builder
                ->add('username', TextType::class, array(
                    'label' => 'form.username',
                    'translation_domain' => 'FOSUserBundle'
                ))
                ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
                ->add('agence', EntityType::class, [
                    'label' => 'Agence',
                    'class' => ConfigAgence::class,
                    'choice_label' => 'libelle',
                    'required' => true,
                    'query_builder' => static function (ConfigAgenceRepository $agenceRepository) use ($userID) {
                        return $agenceRepository->listeAgenceSoc($userID);
                    },
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
        } else {
            $builder
                ->add('username', TextType::class, array(
                    'label' => 'form.username',
                    'translation_domain' => 'FOSUserBundle'
                ))
                ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
                ->add('agence', EntityType::class, [
                    'label' => 'Agence',
                    'class' => ConfigAgence::class,
                    'choice_label' => 'libelle',
                    'required' => true,
                    'query_builder' => static function (ConfigAgenceRepository $agenceRepository) use ($userID) {
                        return $agenceRepository->listeAgenceSoc($userID);
                    },
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


        }


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('role');
    }


    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}