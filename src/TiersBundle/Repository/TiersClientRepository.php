<?php

namespace TiersBundle\Repository;

use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Entity\ConfigSociete;
use UserBundle\Entity\FosUser;

/**
 * TiersClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TiersClientRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchClientName($search){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT t.id, t.nom as text
                      FROM TiersBundle:TiersClient t
                      WHERE t.nom LIKE '%$search%'")
            ->getResult();

    }

    public function listClient(ConfigSociete $societe) {
        return $this->_em->createQuery(
            "select t.id, t.nom, pa.TauxTva tva, c.estPersonneMoral moral, t.ifu
            from TiersBundle:TiersTiers t
            inner join TiersBundle:TiersClient c with c = t
            inner join ConfigBundle:ConfigPaysLang p with p = t.pays
            inner join ConfigBundle:ConfigPays pa with pa = p.pays
            where t.societe = :societe
            and t.estSupprimer = 0 ORDER BY t.created DESC"
        )->setParameter('societe', $societe)
            ->getResult();
    }
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



    public function listeTiersClientSoc($userID = null )
    {
        $societe = $this->_em->getRepository(FosUser::class)->find($userID)->getAgence()->getSociete();

        return $this
            ->createQueryBuilder('a')
            ->innerJoin('a.societe', 's')
            ->where('s = :societe')
            ->setParameter('societe', $societe);
    }
}
