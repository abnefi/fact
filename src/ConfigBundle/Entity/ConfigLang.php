<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lang
 *
 * @ORM\Table(name="Config_Lang")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigLangRepository")
 */
class ConfigLang
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_code", type="string", length=255)
     */
    private $isoCode;

    /**
     * @var string
     *
     * @ORM\Column(name="language_code", type="string", length=5)
     */
    private $languageCode;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="date_format_lite", type="string", length=32)
     */
    private $dateFormatLite;

    /**
     * @var string
     *
     * @ORM\Column(name="date_format_full", type="string", length=32)
     */
    private $dateFormatFull;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_rtl", type="boolean")
     */
    private $isRtl;


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
     * Set name
     *
     * @param string $name
     *
     * @return ConfigLang
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return ConfigLang
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
     * Set isoCode
     *
     * @param string $isoCode
     *
     * @return ConfigLang
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
     * Set languageCode
     *
     * @param string $languageCode
     *
     * @return ConfigLang
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    /**
     * Get languageCode
     *
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return ConfigLang
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set dateFormatLite
     *
     * @param string $dateFormatLite
     *
     * @return ConfigLang
     */
    public function setDateFormatLite($dateFormatLite)
    {
        $this->dateFormatLite = $dateFormatLite;

        return $this;
    }

    /**
     * Get dateFormatLite
     *
     * @return string
     */
    public function getDateFormatLite()
    {
        return $this->dateFormatLite;
    }

    /**
     * Set dateFormatFull
     *
     * @param string $dateFormatFull
     *
     * @return ConfigLang
     */
    public function setDateFormatFull($dateFormatFull)
    {
        $this->dateFormatFull = $dateFormatFull;

        return $this;
    }

    /**
     * Get dateFormatFull
     *
     * @return string
     */
    public function getDateFormatFull()
    {
        return $this->dateFormatFull;
    }

    /**
     * Set isRtl
     *
     * @param boolean $isRtl
     *
     * @return ConfigLang
     */
    public function setIsRtl($isRtl)
    {
        $this->isRtl = $isRtl;

        return $this;
    }

    /**
     * Get isRtl
     *
     * @return boolean
     */
    public function getIsRtl()
    {
        return $this->isRtl;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigLang
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
     * @return ConfigLang
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
     * @return ConfigLang
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
     * @return ConfigLang
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
     * @return ConfigLang
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
}
