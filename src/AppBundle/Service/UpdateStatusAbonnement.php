<?php
/**
 * Created by PhpStorm.
 * User: AHODAN
 * Date: 10/12/2020
 * Time: 16:45
 */

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class UpdateStatusAbonnement
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;


    public function __construct(\Doctrine\ORM\EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function updateAbonnementStatus($societe)
    {
        $ab = $this->em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findOneBy(array('societe' => $societe, 'estActif' => 1, 'estSupprimer' => 0), array('debutAbonnement' => 'DESC'));
       if ($ab !== null){
           $finAb = $ab->getFinAbonnement();
           $date = new \DateTime();
           $finAbonnement = strtotime($finAb->format('Y-m-d'));
           $currentDate = strtotime($date->format('Y-m-d'));
           if ($finAbonnement < $currentDate){
               $ab->setEstActif(0);
               $this->em->persist($ab);
               $this->em->flush();
               return $ab;
           }else{
               return $ab;
           }
       }else{
           return false;
       }

    }

}