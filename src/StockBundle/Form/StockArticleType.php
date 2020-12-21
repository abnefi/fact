<?php

namespace StockBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockArticleType extends StockProduitType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['entity_manager'];
        $referenceGenere = $options['reference_genere']; //Permet de vérifier si la référence de l'article est à générer ou à renseigner manuellement
        parent::buildForm($builder, $options);
        $builder
            ->add('stockAlerte',    null, [
                'attr' => [
                    'class' => 'form-control stockalert',
                ],
                'required' => true,
            ])
            ->add('stockMinimum', NumberType::class, [
                'attr' => [
                    'class' => 'form-control stockmin',
                ],
                'required' => false,
            ]);
       /* if ($referenceGenere === true) { //Si la référence de l'article doit être généré
            $builder->get('reference')->setDisabled(true);
        }*/

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\StockArticle',
            'reference_genere' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stockbundle_stockarticle';
    }


}
