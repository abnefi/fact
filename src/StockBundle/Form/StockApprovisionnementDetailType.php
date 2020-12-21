<?php

namespace StockBundle\Form;

use Proxies\__CG__\StockBundle\Entity\StockArticle;
use StockBundle\Repository\StockArticleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockApprovisionnementDetailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = new Session();
        $userID = $session->get('user_id');
        $builder
            ->add('article',EntityType::class, [
                'label' => "Article",
                'class' => StockArticle::class,
                'choice_label' => 'designation',
                'required' => true,
                'query_builder' => static function (StockArticleRepository $articleRepository) use ($userID) {
                    return $articleRepository->listeArticleSoc($userID);
                },
                'placeholder' => "Sélectionnez un article ",
                'attr' => [
                    'class' => 'form-control chosen-select select_article',
                ],
            ])
            ->add('quantite', null, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('coutAchatUnitaire', null, [
                'label' => 'Coût Achat Unitaire',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\StockApprovisionnementDetail'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stockbundle_stockapprovisionnementdetail';
    }


}
