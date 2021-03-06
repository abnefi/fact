<?php

namespace OperationsClientBundle\Repository;
use ConfigBundle\Entity\ConfigSociete;

/**
 * ClientFactureVenteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientFactureVenteRepository extends \Doctrine\ORM\EntityRepository
{
//    public function getFacturesVenteSansAvoir(ConfigSociete $configSociete)
    public function getFacturesVenteSansAvoir()
    {
        $qb = $this
            ->createQueryBuilder('f')
//            ->leftJoin('f.typeFacture', 'tf')
//            ->where('f.agence = :societe')
//            ->setParameter('societe', $configSociete)
            ->andWhere('f.estValide = true')
            ->andWhere('f.hasAvoir = false')
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }

//    public function getFacturesVente(ConfigSociete $configSociete)
    public function getFacturesVente()
    {
        $qb = $this
            ->createQueryBuilder('f')
//            ->where('f.agence = :societe')
//            ->setParameter('societe', $configSociete)
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }

//    public function getFacturesAvoir(ConfigSociete $configSociete)
//    {
//        $qb = $this
//            ->createQueryBuilder('f')
//            ->leftJoin('f.typeFacture', 'tf')
//            ->where('f.societe = :societe')
//            ->setParameter('societe', $configSociete)
//            ->andWhere('tf.avoir = true')
////            ->andWhere('tf.id IN :typesFactures')
////            ->setParameter('typesFactures', $idsTypesFactures)
//        ;
//
//        return $qb
//            ->getQuery()
//            ->getResult();
//    }
}
