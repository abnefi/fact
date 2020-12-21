<?php

namespace OperationsClientBundle\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientFactureAvoir
 *
 * @ORM\Table(name="client_facture_avoir")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientFactureAvoirRepository")
 */
class ClientFactureAvoir extends ClientFacture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    //Champ valable uniquement pour les factures d'avoir. Il s'agit de la référence de la facture qui a servi pour l'avoir
    /**
     * @var string
     *
     * @ORM\Column(name="reference_facture_origine", type="string", length=255, nullable=true)
     * @Groups({"fact_api"})
     */
    private $referenceFactureOrigine;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date_reglement", type="date")
     */
    private $dateReglement;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     *
     * @ORM\Column(name="updateAt", type="datetime",nullable=true)
     */

    private $updateAt;

    /**
     * @var string
     * @ORM\Column(name="updateBy", type="string", length=255, nullable=true)
     */
    private $updateBy;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->hasAvoir = false;
        $this->estPayee = false;
        $this->estDeclaree = false;
        $this->dateReglement= new \DateTime();
    }

    /**
     * Set referenceFactureOrigine
     *
     * @param string $referenceFactureOrigine
     *
     * @return ClientFactureAvoir
     */
    public function setReferenceFactureOrigine($referenceFactureOrigine)
    {
        $this->referenceFactureOrigine = $referenceFactureOrigine;

        return $this;
    }

    /**
     * Get referenceFactureOrigine
     *
     * @return string
     */
    public function getReferenceFactureOrigine()
    {
        return $this->referenceFactureOrigine;
    }

    /**
     * Set estPayee
     *
     * @param boolean $estPayee
     *
     * @return ClientFactureAvoir
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
     * @return ClientFactureAvoir
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
     * Set dateReglement
     *
     * @param \DateTime $dateReglement
     *
     * @return ClientFactureAvoir
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
     * Set updateAt
     *
     * @param \datetime $updateAt
     *
     * @return ClientFactureAvoir
     */
    public function setUpdateAt(\datetime $updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \datetime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set updateBy
     *
     * @param string $updateBy
     *
     * @return ClientFactureAvoir
     */
    public function setUpdateBy($updateBy)
    {
        $this->updateBy = $updateBy;

        return $this;
    }

    /**
     * Get updateBy
     *
     * @return string
     */
    public function getUpdateBy()
    {
        return $this->updateBy;
    }

    /**
     * Set idLocal
     *
     * @param integer $idLocal
     *
     * @return ClientFactureAvoir
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
