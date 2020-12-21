<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Pays
 *
 * @ORM\Table(name="Config_Pays")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigPaysRepository")
 */
class ConfigPays
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
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigZone")
     * @ORM\JoinColumn(nullable=true)
     */
    private $zone;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_code", type="string", length=3)
     * @Groups({"fact_api"})
     */
    private $isoCode;

    /**
     * @var int
     *
     * @ORM\Column(name="call_prefix", type="integer")
     */
    private $callPrefix;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="contains_states", type="boolean")
     */
    private $containsStates;

    /**
     * @var bool
     *
     * @ORM\Column(name="need_zip_code", type="boolean")
     */
    private $needZipCode;

    /**
     * @var bool
     *
     * @ORM\Column(name="need_identification_number", type="boolean")
     */
    private $needIdentificationNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code_format", type="string", length=12)
     */
    private $zipCodeFormat;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_tax_label", type="boolean")
     */
    private $displayTaxLabel;


    /**
     * @var double
     *
     * @ORM\Column(name="taux_tva", type="float",nullable=true)
     * @Groups({"fact_api"})
     */
    private $TauxTva;


    /**
     * @var double
     *
     * @ORM\Column(name="taux_aib", type="float",nullable=true)
     */
    private $TauxAIB;


    /**
     *
     * @ORM\Column(name="created", type="datetime",nullable=true)
     */

    private $created;


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
        $this->created = new \DateTime();
        $this->estSupprimer = false;
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
     * Set isoCode
     *
     * @param string $isoCode
     *
     * @return ConfigPays
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * Set callPrefix
     *
     * @param integer $callPrefix
     *
     * @return ConfigPays
     */
    public function setCallPrefix($callPrefix)
    {
        $this->callPrefix = $callPrefix;

        return $this;
    }

    /**
     * Get callPrefix
     *
     * @return integer
     */
    public function getCallPrefix()
    {
        return $this->callPrefix;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return ConfigPays
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set containsStates
     *
     * @param boolean $containsStates
     *
     * @return ConfigPays
     */
    public function setContainsStates($containsStates)
    {
        $this->containsStates = $containsStates;

        return $this;
    }

    /**
     * Get containsStates
     *
     * @return boolean
     */
    public function getContainsStates()
    {
        return $this->containsStates;
    }

    /**
     * Set needZipCode
     *
     * @param boolean $needZipCode
     *
     * @return ConfigPays
     */
    public function setNeedZipCode($needZipCode)
    {
        $this->needZipCode = $needZipCode;

        return $this;
    }

    /**
     * Get needZipCode
     *
     * @return boolean
     */
    public function getNeedZipCode()
    {
        return $this->needZipCode;
    }

    /**
     * Set needIdentificationNumber
     *
     * @param boolean $needIdentificationNumber
     *
     * @return ConfigPays
     */
    public function setNeedIdentificationNumber($needIdentificationNumber)
    {
        $this->needIdentificationNumber = $needIdentificationNumber;

        return $this;
    }

    /**
     * Get needIdentificationNumber
     *
     * @return boolean
     */
    public function getNeedIdentificationNumber()
    {
        return $this->needIdentificationNumber;
    }

    /**
     * Set zipCodeFormat
     *
     * @param string $zipCodeFormat
     *
     * @return ConfigPays
     */
    public function setZipCodeFormat($zipCodeFormat)
    {
        $this->zipCodeFormat = $zipCodeFormat;

        return $this;
    }

    /**
     * Get zipCodeFormat
     *
     * @return string
     */
    public function getZipCodeFormat()
    {
        return $this->zipCodeFormat;
    }

    /**
     * Set displayTaxLabel
     *
     * @param boolean $displayTaxLabel
     *
     * @return ConfigPays
     */
    public function setDisplayTaxLabel($displayTaxLabel)
    {
        $this->displayTaxLabel = $displayTaxLabel;

        return $this;
    }

    /**
     * Get displayTaxLabel
     *
     * @return boolean
     */
    public function getDisplayTaxLabel()
    {
        return $this->displayTaxLabel;
    }

    /**
     * Set tauxTva
     *
     * @param float $tauxTva
     *
     * @return ConfigPays
     */
    public function setTauxTva($tauxTva)
    {
        $this->TauxTva = $tauxTva;

        return $this;
    }

    /**
     * Get tauxTva
     *
     * @return float
     */
    public function getTauxTva()
    {
        return $this->TauxTva;
    }

    /**
     * Set tauxAIB
     *
     * @param float $tauxAIB
     *
     * @return ConfigPays
     */
    public function setTauxAIB($tauxAIB)
    {
        $this->TauxAIB = $tauxAIB;

        return $this;
    }

    /**
     * Get tauxAIB
     *
     * @return float
     */
    public function getTauxAIB()
    {
        return $this->TauxAIB;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigPays
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
     * @return ConfigPays
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
     * @return ConfigPays
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
     * @return ConfigPays
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
     * @return ConfigPays
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
     * Set zone
     *
     * @param \ConfigBundle\Entity\ConfigZone $zone
     *
     * @return ConfigPays
     */
    public function setZone(\ConfigBundle\Entity\ConfigZone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \ConfigBundle\Entity\ConfigZone
     */
    public function getZone()
    {
        return $this->zone;
    }
}
