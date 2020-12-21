<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientFactureVente
 *
 * @ORM\Table(name="client_facture_vente")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientFactureVenteRepository")
 */
class ClientFactureVente extends ClientFacture
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
     * @ORM\Column(name="has_avoir", type="boolean")
     */
    private $hasAvoir;

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
     * @var bool
     *
     * @ORM\Column(name="est_cree_par_devis", type="boolean")
     */
    private $estCreeParDevis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reglement", type="date")
     */
    private $dateReglement;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->hasAvoir = false;
        $this->estPayee = false;
        $this->estDeclaree = false;
        $this->estCreeParDevis = false;
    }

    /**
     * Set hasAvoir
     *
     * @param boolean $hasAvoir
     *
     * @return ClientFactureVente
     */
    public function setHasAvoir($hasAvoir)
    {
        $this->hasAvoir = $hasAvoir;

        return $this;
    }

    /**
     * Get hasAvoir
     *
     * @return boolean
     */
    public function getHasAvoir()
    {
        return $this->hasAvoir;
    }

    /**
     * Set estPayee
     *
     * @param boolean $estPayee
     *
     * @return ClientFactureVente
     */
    public function setEstPayee($estPayee)
    {
        $this->estPayee = $estPayee;

        return $this;
    }

    /**
     * Get estPayee
     *
     * @return boolean
     */
    public function getEstPayee()
    {
        return $this->estPayee;
    }

    /**
     * Set estDeclaree
     *
     * @param boolean $estDeclaree
     *
     * @return ClientFactureVente
     */
    public function setEstDeclaree($estDeclaree)
    {
        $this->estDeclaree = $estDeclaree;

        return $this;
    }

    /**
     * Get estDeclaree
     *
     * @return boolean
     */
    public function getEstDeclaree()
    {
        return $this->estDeclaree;
    }

    /**
     * Set estCreeParDevis
     *
     * @param boolean $estCreeParDevis
     *
     * @return ClientFactureVente
     */
    public function setEstCreeParDevis($estCreeParDevis)
    {
        $this->estCreeParDevis = $estCreeParDevis;

        return $this;
    }

    /**
     * Get estCreeParDevis
     *
     * @return boolean
     */
    public function getEstCreeParDevis()
    {
        return $this->estCreeParDevis;
    }

    /**
     * Set dateReglement
     *
     * @param \DateTime $dateReglement
     *
     * @return ClientFactureVente
     */
    public function setDateReglement($dateReglement)
    {
        $this->dateReglement = $dateReglement;

        return $this;
    }

    /**
     * Get dateReglement
     *
     * @return \DateTime
     */
    public function getDateReglement()
    {
        return $this->dateReglement;
    }

    /**
     * Set idLocal
     *
     * @param integer $idLocal
     *
     * @return ClientFactureVente
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
