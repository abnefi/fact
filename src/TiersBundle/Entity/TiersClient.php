<?php

namespace TiersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * TiersClient
 *
 * @ORM\Table(name="tiers_client")
 * @ORM\Entity(repositoryClass="TiersBundle\Repository\TiersClientRepository")
 */
class TiersClient extends TiersTiers
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
     * @var bool
     *
     * @ORM\Column(name="est_personne_moral", type="boolean")
     * @Groups({"fact_api"})
     */
    private $estPersonneMoral;


    public function __construct()
    {
        parent::__construct();
        $this->estPersonneMoral = false;
    }


    /**
     * Set estPersonneMoral
     *
     * @param boolean $estPersonneMoral
     *
     * @return TiersClient
     */
    public function setEstPersonneMoral($estPersonneMoral)
    {
        $this->estPersonneMoral = $estPersonneMoral;

        return $this;
    }

    /**
     * Get estPersonneMoral
     *
     * @return boolean
     */
    public function getEstPersonneMoral()
    {
        return $this->estPersonneMoral;
    }

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
