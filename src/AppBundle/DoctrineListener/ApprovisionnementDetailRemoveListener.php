<?php


namespace AppBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Service\StockOperations;
use StockBundle\Entity\StockApprovisionnementDetail;

class ApprovisionnementDetailRemoveListener
{
//    /**
//     * @var StockOperations
//     */
//    private $stockOperation;
//
//    public function __construct(StockOperations $stockOperation)
//    {
//        $this->stockOperation = $stockOperation;
//    }

    public function preRemove(LifecycleEventArgs $args)
    {
//        dump($args);die();
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof StockApprovisionnementDetail) {
            return;
        }
        $article = $entity->getArticle();
        $newStockDispo = $article->getStockDisponible() - $entity->getQuantite();
        $article->setStockDisponible($newStockDispo);
        $entityManager->persist($article);
//        $entityManager->flush();
//        $this->stockOperation->updateStockDisponibleArticle($entity);
//        dump($newStockDispo);die();
    }
}