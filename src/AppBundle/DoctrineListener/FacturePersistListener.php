<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 28/03/2020
 * Time: 11:10
 */

namespace AppBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OperationsClientBundle\Entity\ClientFacture;

class FacturePersistListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
//        dump($args, $entity);die();

        if (!$entity instanceof ClientFacture) {
            return;
        }
        else{
            if($entity->getTypeFacture()->getDevis() == true){
                return;
            }
        }
        $etatEnAttente = $entityManager->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'FAV']);
        $entity->setEtatDeclaration($etatEnAttente);
        $entityManager->flush();
    }
}