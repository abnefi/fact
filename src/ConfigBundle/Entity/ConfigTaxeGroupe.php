<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ConfigTaxeGroupe
 *
 * @ORM\Table(name="config_taxe_groupe")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigTaxeGroupeRepository")
 */
class ConfigTaxeGroupe
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
     * @ORM\Column(name="code", type="string", length=255)
     * @Groups({"fact_api"})
,     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;


    /**
     *
     * @ORM\Column(name="created", type="datetime",nullable=true)
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
     * @var bool
     *
     * @ORM\Column(name="supprimer", type="boolean")
     */
    private $estSupprimer;


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
        $this->estSupprimmer= false;
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
     * Set code
     *
     * @param string $code
     *
     * @return ConfigTaxeGroupe
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
     * @return ConfigTaxeGroupe
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
     * @return ConfigTaxeGroupe
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
     * @return ConfigTaxeGroupe
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
     * @return ConfigTaxeGroupe
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
     * Set estSupprimer
     *
     * @param boolean $estSupprimer
     *
     * @return ConfigTaxeGroupe
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
     * Set updateBy
     *
     * @param string $updateBy
     *
     * @return ConfigTaxeGroupe
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

    public function __toString()
    {
        return $this->getLibelle();
    }
}
