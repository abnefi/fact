<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigRaisonRejet
 *
 * @ORM\Table(name="config_raison_rejet")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigRaisonRejetRepository")
 */
class ConfigRaisonRejet
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
     * @ORM\Column(name="raison", type="string", length=255)
     */
    private $raison;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     * @var bool
     *
     * @ORM\Column(name="lue", type="boolean")
     */
    private $lue;


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
        $this->estSupprimer = 0;
        $this->created = new \DateTime();
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
     * Set raison
     *
     * @param string $raison
     *
     * @return ConfigRaisonRejet
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * Get raison
     *
     * @return string
     */
    public function getRaison()
    {
        return $this->raison;
    }

    /**
     * Set lue
     *
     * @param boolean $lue
     *
     * @return ConfigRaisonRejet
     */
    public function setLue($lue)
    {
        $this->lue = $lue;

        return $this;
    }

    /**
     * Get lue
     *
     * @return boolean
     */
    public function getLue()
    {
        return $this->lue;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigRaisonRejet
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
     * @return ConfigRaisonRejet
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
     * @return ConfigRaisonRejet
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
     * @return ConfigRaisonRejet
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
     * @return ConfigRaisonRejet
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
     * @return ConfigRaisonRejet
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
}
