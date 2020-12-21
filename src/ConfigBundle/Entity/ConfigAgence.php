<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConfigAgence
 *
 * @ORM\Table(name="config_agence")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigAgenceRepository")
 * @UniqueEntity(fields={"portServeur"}, message="Une Agence est deja associe à ce port")

 */
class ConfigAgence
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
     * @ORM\Column(name="code", type="string", length=100, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete", inversedBy="agences", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"fact_api"})
     */
    private $societe;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_mcf", type="string", length=255)
     *
     * @Groups({"fact_api", "fact_encours_api"})
     */
    private $numeroMCF;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_actif", type="boolean")
     */
    private $estActif;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigPaysLang")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"fact_api"})
     */
    private $paysSise;

    /**
     * @var string
     * @ORM\Column(name="createdBy", type="string", length=255)
     */
    private $createdBy;

    /**
     *
     * @ORM\Column(name="updateAt", type="datetime", nullable=true,nullable=true)
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
     * @var bool
     *
     * @ORM\Column(name="etat_demande", type="boolean",nullable=true)
     */
    private $etatDemande;

    /**
     * @var string
     *
     * @ORM\Column(name="port_serveur", type="string", length=6, nullable=true, unique=true)
     * @Groups({"fact_api"})
     */
    private $portServeur;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     *
     */
    private $ville;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->estActif = false;
        $this->estSupprimer = false;
    }

    public function __toString(): ?string
    {
        return $this->getLibelle();
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
     * Set code
     *
     * @param string $code
     *
     * @return ConfigAgence
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return ConfigAgence
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigAgence
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
     * Set numeroMCF
     *
     * @param string $numeroMCF
     *
     * @return ConfigAgence
     */
    public function setNumeroMCF($numeroMCF)
    {
        $this->numeroMCF = $numeroMCF;

        return $this;
    }

    /**
     * Get numeroMCF
     *
     * @return string
     */
    public function getNumeroMCF()
    {
        return $this->numeroMCF;
    }

    /**
     * Set estActif
     *
     * @param boolean $estActif
     *
     * @return ConfigAgence
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
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return ConfigAgence
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
     * @return ConfigAgence
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
     * @return ConfigAgence
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
     * @return ConfigAgence
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
     * Set etatDemande
     *
     * @param boolean $etatDemande
     *
     * @return ConfigAgence
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
     * Set portServeur
     *
     * @param string $portServeur
     *
     * @return ConfigAgence
     */
    public function setPortServeur($portServeur)
    {
        $this->portServeur = $portServeur;

        return $this;
    }

    /**
     * Get portServeur
     *
     * @return string
     */
    public function getPortServeur()
    {
        return $this->portServeur;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return ConfigAgence
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return ConfigAgence
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
     * Set paysSise
     *
     * @param \ConfigBundle\Entity\ConfigPaysLang $paysSise
     *
     * @return ConfigAgence
     */
    public function setPaysSise(\ConfigBundle\Entity\ConfigPaysLang $paysSise = null)
    {
        $this->paysSise = $paysSise;

        return $this;
    }

    /**
     * Get paysSise
     *
     * @return \ConfigBundle\Entity\ConfigPaysLang
     */
    public function getPaysSise()
    {
        return $this->paysSise;
    }
}
