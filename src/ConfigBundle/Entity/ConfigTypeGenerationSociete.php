<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConfigTypeGenerationSociete
 *
 * @ORM\Table(name="config_type_generation_societe")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigTypeGenerationSocieteRepository")
 */
class ConfigTypeGenerationSociete
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
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigTypeGeneration")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeGeneration;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=true)
     */
    private $societe;

    /**
     * @var bool
     * @ORM\Column(name="estGenere", type="boolean")
     */
    private $estGenere;


    /**
     *
     * @ORM\Column(name="created", type="datetime", nullable=true,nullable=true)
     */

    private $created;


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
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estGenere = false;

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
     * Set estGenere
     *
     * @param boolean $estGenere
     *
     * @return ConfigTypeGenerationSociete
     */
    public function setEstGenere($estGenere)
    {
        $this->estGenere = $estGenere;

        return $this;
    }

    /**
     * Get estGenere
     *
     * @return boolean
     */
    public function getEstGenere()
    {
        return $this->estGenere;
    }

    /**
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return ConfigTypeGenerationSociete
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
     * Set created
     *
     * @param \datetime $created
     *
     * @return ConfigTypeGenerationSociete
     */
    public function setCreated(\datetime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \datetime
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
     * @return ConfigTypeGenerationSociete
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
     * @param \datetime $updateAt
     *
     * @return ConfigTypeGenerationSociete
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
     * @return ConfigTypeGenerationSociete
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
     * @return ConfigTypeGenerationSociete
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
     * Set typeGeneration
     *
     * @param \ConfigBundle\Entity\ConfigTypeGeneration $typeGeneration
     *
     * @return ConfigTypeGenerationSociete
     */
    public function setTypeGeneration(\ConfigBundle\Entity\ConfigTypeGeneration $typeGeneration = null)
    {
        $this->typeGeneration = $typeGeneration;

        return $this;
    }

    /**
     * Get typeGeneration
     *
     * @return \ConfigBundle\Entity\ConfigTypeGeneration
     */
    public function getTypeGeneration()
    {
        return $this->typeGeneration;
    }
}
