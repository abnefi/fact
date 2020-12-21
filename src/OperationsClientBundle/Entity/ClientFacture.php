<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ClientFacture
 *
 * @ORM\Table(name="client_facture")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientFactureRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"avoir" = "ClientFactureAvoir", "vente"="ClientFactureVente", "venteexportation"="ClientFactureVenteExportation",
 *     "avoirexportation"="ClientFactureAvoirExportation", "devis"="ClientDevis", "devisexportation"="ClientDevisExportation"})
 *
 *
 */
abstract class ClientFacture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"fact_api"})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigTypeFacture")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"fact_api"})
     */
    private $typeFacture;

    /**
     * @var string
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     * @Groups({"fact_api", "fact_encours_api"})
     *
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="TiersBundle\Entity\TiersClient")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"fact_api"})
     */
    private $client;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_facture", type="date")
     */
    private $dateFacture;


    /**
     * @var bool
     *
     * @ORM\Column(name="est_valide", type="boolean")
     */
    private $estValide;

    /**
     * @var bool
     *
     * @ORM\Column(name="ecriture_passee", type="boolean")
     */
    private $ecriturePassee;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigAgence")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"fact_api", "fact_encours_api"})
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity="OperationsClientBundle\Entity\ClientFactureDetail", mappedBy="facture",
     *  fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     * @Groups({"fact_api"})
     */
    private $details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\FosUser")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigDevise")
     * @ORM\JoinColumn(nullable=true)
     */
    private $devise;

    /**
     * @var double
     *
     * @ORM\Column(name="taux_change", type="float", nullable=true)
     */
    private $tauxChange;

    /**
     * @var int
     *
     * @ORM\Column(name="id_local", type="integer", nullable=true)
     */
    protected $idLocal;

    /**
     * @var double
     *
     * @ORM\Column(name="taux_tva", type="float")
     * @Groups({"fact_api"})
     */
    private $tauxTVA;

    /**
     * @var bool
     *
     * @ORM\Column(name="application_aib", type="boolean")
     */
    private $applicationAIB;

    /**
     * @ORM\OneToMany(targetEntity="OperationsClientBundle\Entity\ClientPaiement", mappedBy="facture",
     *  fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     *
     * @Groups({"fact_api"})
     */
    private $paiements;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="referenceComptable", type="text", nullable=true)
     */
    private $referenceComptable;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigEtat")
     * @ORM\JoinColumn(nullable=true)
     */
    private $etatDeclaration;

    /**
     * @var double
     *
     * @ORM\Column(name="total_ht", type="float")
     * @Groups({"fact_api"})
     */
    private $totalHT;

    /**
     * @var double
     *
     * @ORM\Column(name="total_tva", type="float")
     * @Groups({"fact_api"})
     */
    private $totalTVA;

    /**
     * @var double
     *
     * @ORM\Column(name="total_aib", type="float")
     * @Groups({"fact_api"})
     */
    private $totalAIB;

    /**
     * @var double
     *
     * @ORM\Column(name="total_ttc", type="float")
     * @Groups({"fact_api"})
     */
    private $totalTTC;

    /**
     * @ORM\ManyToOne(targetEntity="OperationsClientBundle\Entity\ClientFactureReponse")
     * @ORM\JoinColumn(nullable=true)
     */
    private $reponse;


    /**
     * @var bool
     *
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=true)
     */
    private $societe;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->applicationAIB = true;
        $this->estValide = false;
        $this->ecriturePassee = false;
        $this->created = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->details = new \Doctrine\Common\Collections\ArrayCollection();
        $this->paiements = new \Doctrine\Common\Collections\ArrayCollection();

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
     * @return ClientFacture
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
     * Set dateFacture
     *
     * @param \DateTime $dateFacture
     *
     * @return ClientFacture
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    /**
     * Set estValide
     *
     * @param boolean $estValide
     *
     * @return ClientFacture
     */
    public function setEstValide($estValide)
    {
        $this->estValide = $estValide;

        return $this;
    }

    /**
     * Get estValide
     *
     * @return boolean
     */
    public function getEstValide()
    {
        return $this->estValide;
    }

    /**
     * Set ecriturePassee
     *
     * @param boolean $ecriturePassee
     *
     * @return ClientFacture
     */
    public function setEcriturePassee($ecriturePassee)
    {
        $this->ecriturePassee = $ecriturePassee;

        return $this;
    }

    /**
     * Get ecriturePassee
     *
     * @return boolean
     */
    public function getEcriturePassee()
    {
        return $this->ecriturePassee;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ClientFacture
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
     * @return ClientFacture
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
     * Set tauxChange
     *
     * @param float $tauxChange
     *
     * @return ClientFacture
     */
    public function setTauxChange($tauxChange)
    {
        $this->tauxChange = $tauxChange;

        return $this;
    }

    /**
     * Get tauxChange
     *
     * @return float
     */
    public function getTauxChange()
    {
        return $this->tauxChange;
    }

    /**
     * Set tauxTVA
     *
     * @param float $tauxTVA
     *
     * @return ClientFacture
     */
    public function setTauxTVA($tauxTVA)
    {
        $this->tauxTVA = $tauxTVA;

        return $this;
    }

    /**
     * Get tauxTVA
     *
     * @return float
     */
    public function getTauxTVA()
    {
        return $this->tauxTVA;
    }

    /**
     * Set applicationAIB
     *
     * @param boolean $applicationAIB
     *
     * @return ClientFacture
     */
    public function setApplicationAIB($applicationAIB)
    {
        $this->applicationAIB = $applicationAIB;

        return $this;
    }

    /**
     * Get applicationAIB
     *
     * @return boolean
     */
    public function getApplicationAIB()
    {
        return $this->applicationAIB;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return ClientFacture
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set totalHT
     *
     * @param float $totalHT
     *
     * @return ClientFacture
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    /**
     * Get totalHT
     *
     * @return float
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * Set totalTVA
     *
     * @param float $totalTVA
     *
     * @return ClientFacture
     */
    public function setTotalTVA($totalTVA)
    {
        $this->totalTVA = $totalTVA;

        return $this;
    }

    /**
     * Get totalTVA
     *
     * @return float
     */
    public function getTotalTVA()
    {
        return $this->totalTVA;
    }

    /**
     * Set totalAIB
     *
     * @param float $totalAIB
     *
     * @return ClientFacture
     */
    public function setTotalAIB($totalAIB)
    {
        $this->totalAIB = $totalAIB;

        return $this;
    }

    /**
     * Get totalAIB
     *
     * @return float
     */
    public function getTotalAIB()
    {
        return $this->totalAIB;
    }

    /**
     * Set totalTTC
     *
     * @param float $totalTTC
     *
     * @return ClientFacture
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return float
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * Set typeFacture
     *
     * @param \ConfigBundle\Entity\ConfigTypeFacture $typeFacture
     *
     * @return ClientFacture
     */
    public function setTypeFacture(\ConfigBundle\Entity\ConfigTypeFacture $typeFacture)
    {
        $this->typeFacture = $typeFacture;

        return $this;
    }

    /**
     * Get typeFacture
     *
     * @return \ConfigBundle\Entity\ConfigTypeFacture
     */
    public function getTypeFacture()
    {
        return $this->typeFacture;
    }

    /**
     * Set client
     *
     * @param \TiersBundle\Entity\TiersClient $client
     *
     * @return ClientFacture
     */
    public function setClient(\TiersBundle\Entity\TiersClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \TiersBundle\Entity\TiersClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set agence
     *
     * @param \ConfigBundle\Entity\ConfigAgence $agence
     *
     * @return ClientFacture
     */
    public function setAgence(\ConfigBundle\Entity\ConfigAgence $agence = null)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get agence
     *
     * @return \ConfigBundle\Entity\ConfigAgence
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * Add detail
     *
     * @param \OperationsClientBundle\Entity\ClientFactureDetail $detail
     *
     * @return ClientFacture
     */
    public function addDetail(ClientFactureDetail $detail)
    {
        $this->details[] = $detail;

        return $this;
    }

    /**
     * Remove detail
     *
     * @param \OperationsClientBundle\Entity\ClientFactureDetail $detail
     */
    public function removeDetail(\OperationsClientBundle\Entity\ClientFactureDetail $detail)
    {
        $this->details->removeElement($detail);
    }

    /**
     * Get details
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\FosUser $user
     *
     * @return ClientFacture
     */
    public function setUser(\UserBundle\Entity\FosUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\FosUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set devise
     *
     * @param \ConfigBundle\Entity\ConfigDevise $devise
     *
     * @return ClientFacture
     */
    public function setDevise(\ConfigBundle\Entity\ConfigDevise $devise = null)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return \ConfigBundle\Entity\ConfigDevise
     */
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Add paiement
     *
     * @param \OperationsClientBundle\Entity\ClientPaiement $paiement
     *
     * @return ClientFacture
     */
    public function addPaiement(\OperationsClientBundle\Entity\ClientPaiement $paiement)
    {
        $this->paiements[] = $paiement;

        return $this;
    }

    /**
     * Remove paiement
     *
     * @param \OperationsClientBundle\Entity\ClientPaiement $paiement
     */
    public function removePaiement(\OperationsClientBundle\Entity\ClientPaiement $paiement)
    {
        $this->paiements->removeElement($paiement);
    }

    /**
     * Get paiements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaiements()
    {
        return $this->paiements;
    }

    /**
     * Set etatDeclaration
     *
     * @param \ConfigBundle\Entity\ConfigEtat $etatDeclaration
     *
     * @return ClientFacture
     */
    public function setEtatDeclaration(\ConfigBundle\Entity\ConfigEtat $etatDeclaration = null)
    {
        $this->etatDeclaration = $etatDeclaration;

        return $this;
    }

    /**
     * Get etatDeclaration
     *
     * @return \ConfigBundle\Entity\ConfigEtat
     */
    public function getEtatDeclaration()
    {
        return $this->etatDeclaration;
    }

    /**
     * Set reponse
     *
     * @param \OperationsClientBundle\Entity\ClientFactureReponse $reponse
     *
     * @return ClientFacture
     */
    public function setReponse(\OperationsClientBundle\Entity\ClientFactureReponse $reponse = null)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return \OperationsClientBundle\Entity\ClientFactureReponse
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set referenceComptable
     *
     * @param string $referenceComptable
     *
     * @return ClientFacture
     */
    public function setReferenceComptable($referenceComptable)
    {
        $this->referenceComptable = $referenceComptable;

        return $this;
    }

    /**
     * Get referenceComptable
     *
     * @return string
     */
    public function getReferenceComptable()
    {
        return $this->referenceComptable;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return ClientFacture
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
     * @return ClientFacture
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
     * @return ClientFacture
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
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return ClientFacture
     */
    public function setSociete(\ConfigBundle\Entity\ConfigSociete $societe = null)
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
     * Set idLocal
     *
     * @param integer $idLocal
     *
     * @return ClientFacture
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
