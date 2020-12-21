<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConfigTaux
 *
 * @ORM\Table(name="config_taux")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigTauxRepository")
 */
class ConfigTaux
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
     * @ORM\OneToOne(targetEntity="ConfigBundle\Entity\ConfigTaux", cascade={"persist", "remove"})
     */
    private $configTaux_id;



    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, unique=true)
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var double
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="valeur_taux", type="float")
     */
    private $valeurTaux;


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
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;


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
     * @return ConfigTaux
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
     * @return ConfigTaux
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
     * Set valeurTaux
     *
     * @param float $valeurTaux
     *
     * @return ConfigTaux
     */
    public function setValeurTaux($valeurTaux)
    {
        $this->valeurTaux = $valeurTaux;

        return $this;
    }

    /**
     * Get valeurTaux
     *
     * @return float
     */
    public function getValeurTaux()
    {
        return $this->valeurTaux;
    }

    /**
     * Set configTauxId
     *
     * @param \ConfigBundle\Entity\ConfigTaux $configTauxId
     *
     * @return ConfigTaux
     */
    public function setConfigTauxId(\ConfigBundle\Entity\ConfigTaux $configTauxId = null)
    {
        $this->configTaux_id = $configTauxId;

        return $this;
    }

    /**
     * Get configTauxId
     *
     * @return \ConfigBundle\Entity\ConfigTaux
     */
    public function getConfigTauxId()
    {
        return $this->configTaux_id;
    }

    /**
     * Set created
     *
     * @param \datetime $created
     *
     * @return ConfigTaux
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
     * @return ConfigTaux
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
     * @return ConfigTaux
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
     * @return ConfigTaux
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
     * @return ConfigTaux
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
