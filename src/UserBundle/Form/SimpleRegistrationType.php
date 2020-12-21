<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 18/03/2020
 * Time: 11:57
 */

namespace UserBundle\Form;

use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Form\ConfigSocieteType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SimpleRegistrationType extends RegistrationType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
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
            ]);

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
}