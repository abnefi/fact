<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClientFactureDetail
 *
 * @ORM\Table(name="client_facture_detail")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientFactureDetailRepository")
 */
class ClientFactureDetail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="OperationsClientBundle\Entity\ClientFacture", inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\StockProduit")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"fact_api"})
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigUniteMesure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $uniteMesure;

    /**
     * @var double
     *@Assert\NotBlank
     * @ORM\Column(name="quantite", type="float")
     * @Groups({"fact_api"})
     */
    private $quantite;

    /**
     * @var double
     * @Assert\NotBlank
     * @ORM\Column(name="prix_vente_unitaire", type="float")
     * @Groups({"fact_api"})
     */
    private $prixVenteUnitaire;

    /**
     * @var double
     * @ORM\Column(name="taux_remise", type="float", nullable=true)
     * @Groups({"fact_api"})
     */
    private $tauxRemise;

    /**
     * @var bool
     *
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;

    /**
     * @var bool
     *
     * @ORM\Column(name="aib_deductible", type="boolean")
     * @Groups({"fact_api"})
     */
    private $aibDeductible;

    /**
     * @var double
     *
     * @ORM\Column(name="taux_aib", type="float")
     * @Groups({"fact_api"})
     */
    private $tauxAIB;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_taxe_specifique", type="boolean")
     * @Groups({"fact_api"})
     *
     * Permet de spécifier si l'aricle a une taxe spécifique
     */
    private $hasTaxeSpecifique;

    /**
     * @var double
     *
     * @ORM\Column(name="taxe_specifique", type="float",  nullable=true)
     * @Groups({"fact_api"})
     */
    private $taxeSpecifique;

    /**
     * @var string
     *
     * @ORM\Column(name="description_taxe_specifique", type="text", nullable=true)
     * @Groups({"fact_api"})
     */
    private $descriptionTaxeSpecifique;

    /**
     * @var bool
     *
     * @ORM\Column(name="changement_prix_unitaire_ttc", type="boolean")
     *
     * Permet de spécifier si le prix unitaire TTC de l'aricle a changé par rapport au dernier prix sur la dernière facture
     */
    private $changementPrixUnitaireTTC;

    /**
     * @var double
     *
     * @ORM\Column(name="dernier_prix_origine", type="float",  nullable=true)
     */
    private $dernierPrixOrigine;

    /**
     * @var string
     *
     * @ORM\Column(name="description_prix_origine", type="text", nullable=true)
     */
    private $descriptionPrixOrigine;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;



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
     * @var double
     * @ORM\Column(name="taxe_de_sejour", type="float", nullable=true)
     * @Groups({"fact_api"})
     */
    private $taxeDeSejour;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->tauxRemise = 0;
        $this->taxeSpecifique = 0;
//        $this->tauxAIB = 1;
//        $this->tauxTVA = 18;
        $this->quantite = 0;
        $this->prixVenteUnitaire = 0;
        $this->tauxRemise = 0;
        $this->tauxAIB = 0;
        $this->aibDeductible = 0;
        $this->taxeSpecifique = 0;
        $this->taxeDeSejour = 0;
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
     * Set quantite
     *
     * @param float $quantite
     *
     * @return ClientFactureDetail
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return float
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixVenteUnitaire
     *
     * @param float $prixVenteUnitaire
     *
     * @return ClientFactureDetail
     */
    public function setPrixVenteUnitaire($prixVenteUnitaire)
    {
        $this->prixVenteUnitaire = $prixVenteUnitaire;

        return $this;
    }

    /**
     * Get prixVenteUnitaire
     *
     * @return float
     */
    public function getPrixVenteUnitaire()
    {
        return $this->prixVenteUnitaire;
    }

    /**
     * Set tauxRemise
     *
     * @param float $tauxRemise
     *
     * @return ClientFactureDetail
     */
    public function setTauxRemise($tauxRemise)
    {
        $this->tauxRemise = $tauxRemise;

        return $this;
    }

    /**
     * Get tauxRemise
     *
     * @return float
     */
    public function getTauxRemise()
    {
        return $this->tauxRemise;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ClientFactureDetail
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
     * Set changementPrixUnitaireTTC
     *
     * @param boolean $changementPrixUnitaireTTC
     *
     * @return ClientFactureDetail
     */
    public function setChangementPrixUnitaireTTC($changementPrixUnitaireTTC)
    {
        $this->changementPrixUnitaireTTC = $changementPrixUnitaireTTC;

        return $this;
    }

    /**
     * Get changementPrixUnitaireTTC
     *
     * @return boolean
     */
    public function getChangementPrixUnitaireTTC()
    {
        return $this->changementPrixUnitaireTTC;
    }

    /**
     * Set dernierPrixOrigine
     *
     * @param float $dernierPrixOrigine
     *
     * @return ClientFactureDetail
     */
    public function setDernierPrixOrigine($dernierPrixOrigine)
    {
        $this->dernierPrixOrigine = $dernierPrixOrigine;

        return $this;
    }

    /**
     * Get dernierPrixOrigine
     *
     * @return float
     */
    public function getDernierPrixOrigine()
    {
        return $this->dernierPrixOrigine;
    }

    /**
     * Set descriptionPrixOrigine
     *
     * @param string $descriptionPrixOrigine
     *
     * @return ClientFactureDetail
     */
    public function setDescriptionPrixOrigine($descriptionPrixOrigine)
    {
        $this->descriptionPrixOrigine = $descriptionPrixOrigine;

        return $this;
    }

    /**
     * Get descriptionPrixOrigine
     *
     * @return string
     */
    public function getDescriptionPrixOrigine()
    {
        return $this->descriptionPrixOrigine;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return ClientFactureDetail
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
     * Set facture
     *
     * @param \OperationsClientBundle\Entity\ClientFacture $facture
     *
     * @return ClientFactureDetail
     */
    public function setFacture(\OperationsClientBundle\Entity\ClientFacture $facture)
    {
        $this->facture = $facture;
        $facture->addDetail($this);
        return $this;
    }

    /**
     * Get facture
     *
     * @return \OperationsClientBundle\Entity\ClientFacture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set produit
     *
     * @param \StockBundle\Entity\StockProduit $produit
     *
     * @return ClientFactureDetail
     */
    public function setProduit(\StockBundle\Entity\StockProduit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \StockBundle\Entity\StockProduit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set uniteMesure
     *
     * @param \ConfigBundle\Entity\ConfigUniteMesure $uniteMesure
     *
     * @return ClientFactureDetail
     */
    public function setUniteMesure(\ConfigBundle\Entity\ConfigUniteMesure $uniteMesure = null)
    {
        $this->uniteMesure = $uniteMesure;

        return $this;
    }

    /**
     * Get uniteMesure
     *
     * @return \ConfigBundle\Entity\ConfigUniteMesure
     */
    public function getUniteMesure()
    {
        return $this->uniteMesure;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ClientFactureDetail
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
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return ClientFactureDetail
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
     * @return ClientFactureDetail
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
     * Set estSupprimer
     *
     * @param boolean $estSupprimer
     *
     * @return ClientFactureDetail
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
     * Set aibDeductible
     *
     * @param boolean $aibDeductible
     *
     * @return ClientFactureDetail
     */
    public function setAibDeductible($aibDeductible)
    {
        $this->aibDeductible = $aibDeductible;

        return $this;
    }

    /**
     * Get aibDeductible
     *
     * @return boolean
     */
    public function getAibDeductible()
    {
        return $this->aibDeductible;
    }

    /**
     * Set tauxAIB
     *
     * @param float $tauxAIB
     *
     * @return ClientFactureDetail
     */
    public function setTauxAIB($tauxAIB)
    {
        if ($tauxAIB > 1) {
            $tauxAIB /= 100;
        }
        $this->tauxAIB = $tauxAIB;

        return $this;
    }

    /**
     * Get tauxAIB
     *
     * @return float
     */
    public function getTauxAIB()
    {
        return $this->tauxAIB;
    }

    /**
     * Set hasTaxeSpecifique
     *
     * @param boolean $hasTaxeSpecifique
     *
     * @return ClientFactureDetail
     */
    public function setHasTaxeSpecifique($hasTaxeSpecifique)
    {
        $this->hasTaxeSpecifique = $hasTaxeSpecifique;

        return $this;
    }

    /**
     * Get hasTaxeSpecifique
     *
     * @return boolean
     */
    public function getHasTaxeSpecifique()
    {
        return $this->hasTaxeSpecifique;
    }

    /**
     * Set taxeSpecifique
     *
     * @param float $taxeSpecifique
     *
     * @return ClientFactureDetail
     */
    public function setTaxeSpecifique($taxeSpecifique)
    {
        $this->taxeSpecifique = $taxeSpecifique;

        return $this;
    }

    /**
     * Get taxeSpecifique
     *
     * @return float
     */
    public function getTaxeSpecifique()
    {
        return $this->taxeSpecifique;
    }

    /**
     * Set descriptionTaxeSpecifique
     *
     * @param string $descriptionTaxeSpecifique
     *
     * @return ClientFactureDetail
     */
    public function setDescriptionTaxeSpecifique($descriptionTaxeSpecifique)
    {
        $this->descriptionTaxeSpecifique = $descriptionTaxeSpecifique;

        return $this;
    }

    /**
     * Get descriptionTaxeSpecifique
     *
     * @return string
     */
    public function getDescriptionTaxeSpecifique()
    {
        return $this->descriptionTaxeSpecifique;
    }

    /**
     * Set taxeDeSejour
     *
     * @param float $taxeDeSejour
     *
     * @return ClientFactureDetail
     */
    public function setTaxeDeSejour($taxeDeSejour)
    {
        $this->taxeDeSejour = $taxeDeSejour;

        return $this;
    }

    /**
     * Get taxeDeSejour
     *
     * @return float
     */
    public function getTaxeDeSejour()
    {
        return $this->taxeDeSejour;
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $this->facture = null;
        }
    }
}
