<?php


namespace AppBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use StockBundle\Entity\StockApprovisionnementDetail;

class ApprovisionnementDetailPersistListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
//        dump($args);die();
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof StockApprovisionnementDetail) {
            return;
        }
        $article = $entity->getArticle();
        $newStockDispo = $article->getStockDisponible() + $entity->getQuantite();

        $article->setStockDisponible($newStockDispo);
        $entityManager->persist($article);
//        $entityManager->flush();
//        $this->stockOperation->updateStockDisponibleArticle($entity);
    }
}