<?php

namespace TiersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TiersFournisseur
 *
 * @ORM\Table(name="tiers_fournisseur")
 * @ORM\Entity(repositoryClass="TiersBundle\Repository\TiersFournisseurRepository")
 */
class TiersFournisseur extends TiersTiers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
