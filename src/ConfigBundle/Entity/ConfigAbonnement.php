<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigAbonnement
 *
 * @ORM\Table(name="config_abonnement")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigAbonnementRepository")
 */
class ConfigAbonnement
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
     * @ORM\Column(name="libelle", type="string", length=255,unique=true)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="nombrejour", type="integer")
     */
    private $nombreJour;

    /**
     * @var int
     *
     * @ORM\Column(name="limite_agence", type="integer",nullable=true)
     */
    private $limiteAgence;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="flyer_image", type="string", length=255,nullable=true)
     */
    private $flyerImage;

    /**
     * @var bool
     *
     * @ORM\Column(name="estActif", type="boolean")
     */
    private $estActif;


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
        $this->createdAt = new \DateTime();
        $this->updateAt = new \DateTime();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return ConfigAbonnement
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
     * Set nombreJour
     *
     * @param integer $nombreJour
     *
     * @return ConfigAbonnement
     */
    public function setNombreJour($nombreJour)
    {
        $this->nombreJour = $nombreJour;

        return $this;
    }

    /**
     * Get nombreJour
     *
     * @return integer
     */
    public function getNombreJour()
    {
        return $this->nombreJour;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return ConfigAbonnement
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set estActif
     *
     * @param boolean $estActif
     *
     * @return ConfigAbonnement
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ConfigAbonnement
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
     * @return ConfigAbonnement
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
     * @return ConfigAbonnement
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
     * @return ConfigAbonnement
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
     * @return ConfigAbonnement
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
     * Set description
     *
     * @param string $description
     *
     * @return ConfigAbonnement
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
     * Set flyerImage
     *
     * @param string $flyerImage
     *
     * @return ConfigAbonnement
     */
    public function setFlyerImage($flyerImage)
    {
        $this->flyerImage = $flyerImage;

        return $this;
    }

    /**
     * Get flyerImage
     *
     * @return string
     */
    public function getFlyerImage()
    {
        return $this->flyerImage;
    }

    /**
     * Set limiteAgence
     *
     * @param integer $limiteAgence
     *
     * @return ConfigAbonnement
     */
    public function setLimiteAgence($limiteAgence)
    {
        $this->limiteAgence = $limiteAgence;

        return $this;
    }

    /**
     * Get limiteAgence
     *
     * @return integer
     */
    public function getLimiteAgence()
    {
        return $this->limiteAgence;
    }
}
