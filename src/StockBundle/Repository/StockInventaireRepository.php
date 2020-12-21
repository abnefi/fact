<?php

namespace StockBundle\Repository;

use ConfigBundle\Entity\ConfigSociete;
use StockBundle\Entity\StockInventaire;

/**
 * StockInventaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StockInventaireRepository extends \Doctrine\ORM\EntityRepository
{
    /*public function taille($societe)
    {
        $qb = $this
            ->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.societe = :soc')
            ->setParameter('soc', $societe);

        return $qb
            ->getQuery()
            ->getResult();
    }*/
    public function taille($societe)
    {
        $tab = $this->_em->createQuery(
            "select count(a)
            from StockBundle:StockArticle a
            inner join ConfigBundle:ConfigSociete s with s = a.societe
            where s = :soc"
        )
            ->setParameter('soc', $societe)
            ->getResult();
        return $tab[0][1];
    }
}
