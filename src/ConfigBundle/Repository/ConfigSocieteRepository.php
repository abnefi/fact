<?php

namespace ConfigBundle\Repository;

/**
 * ConfigSocieteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConfigSocieteRepository extends \Doctrine\ORM\EntityRepository
{
    public function taille()
    {
        $tab = $this->_em->createQuery(
            "select count(a)
            from ConfigBundle:ConfigSociete a"
        )
            ->getResult();
        return $tab[0][1];
    }

}
