<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigAbonnementSociete
 *
 * @ORM\Table(name="config_abonnement_societe")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigAbonnementSocieteRepository")
 */
class ConfigAbonnementSociete
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debutAbonnement", type="datetime",nullable=true)
     */
    private $debutAbonnement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finAbonnement", type="datetime",nullable=true)
     */
    private $finAbonnement;

    /**
     * @var bool
     *
     * @ORM\Column(name="reabonnementAuto", type="boolean")
     */
    private $reabonnementAuto;


    /**
     * @var string
     *
     * @ORM\Column(name="fichier_paie", type="string", length=255,nullable=false)
     */
    private $fichierPaie;

    /**
     * @var string
     *
     * @ORM\Column(name="note_details", type="string", length=255,nullable=true)
     */
    private $noteDetails;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigBanque")
     */
    private $banque;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete", inversedBy="abonnement")
     * @ORM\JoinColumn(nullable=true)
     */
    private $societe;

    /**
     * @var bool
     *
     * @ORM\Column(name="estActif", type="boolean")
     */
    private $estActif;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat_demande", type="boolean")
     */
    private $etatDemande;


    /**
     * @var string
     *
     * @ORM\Column(name="decision_admin", type="string", length=255,nullable=true)
     */
    private $decisionAdmin;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigAbonnement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeAbonnement;

    /**
     *
     * @ORM\Column(name="created", type="datetime",nullable=true)
     */

    private $createdAt;


    /**
     * @var string
     * @ORM\Column(name="createdBy", type="string", length=255,nullable=true)
     */
    private $createdBy;

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
     * @var bool
     *
     * @ORM\Column(name="estSupprimer", type="boolean", nullable=true)
     */
    private $estSupprimer;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estSupprimer = false;
        $this->estActif = false;
        $this->etatDemande = false;
        $this->createdAt = new \DateTime();
        $this->updateAt = new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return ConfigAbonnementSociete
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set debutAbonnement
     *
     * @param \DateTime $debutAbonnement
     *
     * @return ConfigAbonnementSociete
     */
    public function setDebutAbonnement($debutAbonnement)
    {
        $this->debutAbonnement = $debutAbonnement;

        return $this;
    }

    /**
     * Get debutAbonnement
     *
     * @return \DateTime
     */
    public function getDebutAbonnement()
    {
        return $this->debutAbonnement;
    }

    /**
     * Set finAbonnement
     *
     * @param \DateTime $finAbonnement
     *
     * @return ConfigAbonnementSociete
     */
    public function setFinAbonnement($finAbonnement)
    {
        $this->finAbonnement = $finAbonnement;

        return $this;
    }

    /**
     * Get finAbonnement
     *
     * @return \DateTime
     */
    public function getFinAbonnement()
    {
        return $this->finAbonnement;
    }

    /**
     * Set reabonnementAuto
     *
     * @param boolean $reabonnementAuto
     *
     * @return ConfigAbonnementSociete
     */
    public function setReabonnementAuto($reabonnementAuto)
    {
        $this->reabonnementAuto = $reabonnementAuto;

        return $this;
    }

    /**
     * Get reabonnementAuto
     *
     * @return bool
     */
    public function getReabonnementAuto()
    {
        return $this->reabonnementAuto;
    }

    /**
     * Set estActif
     *
     * @param boolean $estActif
     *
     * @return ConfigAbonnementSociete
     */
    public function setEstActif($estActif)
    {
        $this->estActif = $estActif;

        return $this;
    }

    /**
     * Get estActif
     *
     * @return bool
     */
    public function getEstActif()
    {
        return $this->estActif;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ConfigAbonnementSociete
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return ConfigAbonnementSociete
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return ConfigAbonnementSociete
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
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
     * @return ConfigAbonnementSociete
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
     * @return ConfigAbonnementSociete
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


    public function __toString(): ?string
    {
        return $this->getLibelle();
    }



    /**
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return ConfigAbonnementSociete
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
     * Set typeAbonnement
     *
     * @param \ConfigBundle\Entity\ConfigAbonnement $typeAbonnement
     *
     * @return ConfigAbonnementSociete
     */
    public function setTypeAbonnement(\ConfigBundle\Entity\ConfigAbonnement $typeAbonnement)
    {
        $this->typeAbonnement = $typeAbonnement;

        return $this;
    }

    /**
     * Get typeAbonnement
     *
     * @return \ConfigBundle\Entity\ConfigAbonnement
     */
    public function getTypeAbonnement()
    {
        return $this->typeAbonnement;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return ConfigAbonnementSociete
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set fichierPaie
     *
     * @param string $fichierPaie
     *
     * @return ConfigAbonnementSociete
     */
    public function setFichierPaie($fichierPaie)
    {
        $this->fichierPaie = $fichierPaie;

        return $this;
    }

    /**
     * Get fichierPaie
     *
     * @return string
     */
    public function getFichierPaie()
    {
        return $this->fichierPaie;
    }

    /**
     * Set etatDemande
     *
     * @param boolean $etatDemande
     *
     * @return ConfigAbonnementSociete
     */
    public function setEtatDemande($etatDemande)
    {
        $this->etatDemande = $etatDemande;

        return $this;
    }

    /**
     * Get etatDemande
     *
     * @return boolean
     */
    public function getEtatDemande()
    {
        return $this->etatDemande;
    }

    /**
     * Set decisionAdmin
     *
     * @param string $decisionAdmin
     *
     * @return ConfigAbonnementSociete
     */
    public function setDecisionAdmin($decisionAdmin)
    {
        $this->decisionAdmin = $decisionAdmin;

        return $this;
    }

    /**
     * Get decisionAdmin
     *
     * @return string
     */
    public function getDecisionAdmin()
    {
        return $this->decisionAdmin;
    }

    /**
     * Set noteDetails
     *
     * @param string $noteDetails
     *
     * @return ConfigAbonnementSociete
     */
    public function setNoteDetails($noteDetails)
    {
        $this->noteDetails = $noteDetails;

        return $this;
    }

    /**
     * Get noteDetails
     *
     * @return string
     */
    public function getNoteDetails()
    {
        return $this->noteDetails;
    }

    /**
     * Set banque
     *
     * @param \ConfigBundle\Entity\ConfigBanque $banque
     *
     * @return ConfigAbonnementSociete
     */
    public function setBanque(\ConfigBundle\Entity\ConfigBanque $banque = null)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return \ConfigBundle\Entity\ConfigBanque
     */
    public function getBanque()
    {
        return $this->banque;
    }
}
