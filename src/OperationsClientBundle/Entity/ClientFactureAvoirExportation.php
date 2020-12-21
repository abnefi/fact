<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ClientFactureAvoirExportation
 *
 * @ORM\Table(name="client_facture_avoir_exportation")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientFactureAvoirExportationRepository")
 */
class ClientFactureAvoirExportation extends ClientFactureAvoir
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
     * @ORM\Column(name="est_payee", type="boolean")
     */
    private $estPayee;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_declaree", type="boolean")
     */
    private $estDeclaree;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->hasAvoir = false;
        $this->estPayee = false;
        $this->estDeclaree = false;
    }

    

    /**
     * Set idLocal
     *
     * @param integer $idLocal
     *
     * @return ClientFactureAvoirExportation
     */
    public function setIdLocal($idLocal)
    {
        $this->idLocal = $idLocal;

        return $this;
    }

    /**
     * Get idLocal
     *
     * @return integer
     */
    public function getIdLocal()
    {
        return $this->idLocal;
    }
}
