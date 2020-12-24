<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * StockProduit
 *
 * @ORM\Table(name="stock_produit")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockProduitRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"produit" = "StockProduit", "article" = "StockArticle", "service"="StockService"})
 * @UniqueEntity(fields={"referenceInterne"}, message="Un Produit est deja associe à cette référence")
 */
class StockProduit
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
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=50)
     *
     * @Groups({"fact_api"})
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Groups({"fact_api"})
     */
    private $designation;

    /**
     * @var double
     * @Assert\NotBlank
     * @ORM\Column(name="prix_unitaire_vente", type="float", nullable=false)
     */
    private $prixUnitaireVente;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_actif", type="boolean")
     */
    private $estActif;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_supprimer", type="boolean")
     */
    private $estSupprimer;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_perimer", type="boolean")
     */
    private $estPerimer;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_perissable", type="boolean")
     */
    private $estPerissable;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigAgence")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agence_id;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="reference_interne", type="string", length=100, nullable=true, unique=true)
     */
    private $referenceInterne;


    /**
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\StockCategorie", inversedBy="produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */

    private $created;
    /**
     *
     * @ORM\Column(name="date_peremption", type="datetime", nullable=true)
     */
    private $datePeremption;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * @var string
     * @ORM\Column(name="createdBy", type="string", length=255)
     */
    private $createdBy;


    /**
     * @var string
     * @ORM\Column(name="updateBy", type="string", length=255, nullable=true)
     */
    private $updateBy;





    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigTaxeGroupe")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"fact_api"})
     */
    private $taxeGroupe;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estSupprimer = false;
        $this->estPerissable = false;
        $this->estPerimer = false;
        $this->estActif = true;
        $this->estPerissable=false;
        $this->estPerimer=false;
        $this->estSupprimer= false;
        $this->created = new \DateTime();
        $this->datePeremption = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
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

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return StockProduit
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return StockProduit
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set prixUnitaireVente
     *
     * @param float $prixUnitaireVente
     *
     * @return StockProduit
     */
    public function setPrixUnitaireVente($prixUnitaireVente)
    {
        $this->prixUnitaireVente = $prixUnitaireVente;

        return $this;
    }

    /**
     * Get prixUnitaireVente
     *
     * @return float
     */
    public function getPrixUnitaireVente()
    {
        return $this->prixUnitaireVente;
    }

    /**
     * Set estActif
     *
     * @param boolean $estActif
     *
     * @return StockProduit
     */
    public function setEstActif($estActif)
    {
        $this->estActif = $estActif;

        return $this;
    }

    /**
     * Get estActif
     *
     * @return boolean
     */
    public function getEstActif()
    {
        return $this->estActif;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return StockProduit
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return StockProduit
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }



    /**
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return StockProduit
     */
    public function setSociete(\ConfigBundle\Entity\ConfigSociete $societe)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return \ConfigBundle\Entity\ConfigSociete
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set estSupprimer
     *
     * @param boolean $estSupprimer
     *
     * @return StockProduit
     */
    public function setEstSupprimer($estSupprimer)
    {
        $this->estSupprimer = $estSupprimer;

        return $this;
    }

    /**
     * Get estSupprimer
     *
     * @return boolean
     */
    public function getEstSupprimer()
    {
        return $this->estSupprimer;
    }

    /**
     * Set estPerimer
     *
     * @param boolean $estPerimer
     *
     * @return StockProduit
     */
    public function setEstPerimer($estPerimer)
    {
        $this->estPerimer = $estPerimer;

        return $this;
    }

    /**
     * Get estPerimer
     *
     * @return boolean
     */
    public function getEstPerimer()
    {
        return $this->estPerimer;
    }

    /**
     * Set estPerissable
     *
     * @param boolean $estPerissable
     *
     * @return StockProduit
     */
    public function setEstPerissable($estPerissable)
    {
        $this->estPerissable = $estPerissable;

        return $this;
    }

    /**
     * Get estPerissable
     *
     * @return boolean
     */
    public function getEstPerissable()
    {
        return $this->estPerissable;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return StockProduit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datePeremption
     *
     * @param \DateTime $datePeremption
     *
     * @return StockProduit
     */
    public function setDatePeremption($datePeremption)
    {
        $this->datePeremption = $datePeremption;

        return $this;
    }

    /**
     * Get datePeremption
     *
     * @return \DateTime
     */
    public function getDatePeremption()
    {
        return $this->datePeremption;
    }

    /**
     * Set agenceId
     *
     * @param \ConfigBundle\Entity\ConfigAgence $agenceId
     *
     * @return StockProduit
     */
    public function setAgenceId(\ConfigBundle\Entity\ConfigAgence $agenceId)
    {
        $this->agence_id = $agenceId;

        return $this;
    }

    /**
     * Get agenceId
     *
     * @return \ConfigBundle\Entity\ConfigAgence
     */
    public function getAgenceId()
    {
        return $this->agence_id;
    }

    /**
     * Set categorie
     *
     * @param \StockBundle\Entity\StockCategorie $categorie
     *
     * @return StockProduit
     */
    public function setCategorie(\StockBundle\Entity\StockCategorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \StockBundle\Entity\StockCategorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return StockProduit
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updateBy
     *
     * @param string $updateBy
     *
     * @return StockProduit
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
     * Set referenceInterne
     *
     * @param string $referenceInterne
     *
     * @return StockProduit
     */
    public function setReferenceInterne($referenceInterne)
    {
        $this->referenceInterne = $referenceInterne;

        return $this;
    }

    /**
     * Get referenceInterne
     *
     * @return string
     */
    public function getReferenceInterne()
    {
        return $this->referenceInterne;
    }

    /**
     * Set taxeGroupe
     *
     * @param \ConfigBundle\Entity\ConfigTaxeGroupe $taxeGroupe
     *
     * @return StockProduit
     */
    public function setTaxeGroupe(\ConfigBundle\Entity\ConfigTaxeGroupe $taxeGroupe = null)
    {
        $this->taxeGroupe = $taxeGroupe;

        return $this;
    }

    /**
     * Get taxeGroupe
     *
     * @return \ConfigBundle\Entity\ConfigTaxeGroupe
     */
    public function getTaxeGroupe()
    {
        return $this->taxeGroupe;
    }
}
