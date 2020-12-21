<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * PaysLang
 *
 * @ORM\Table(name="Config_Pays_Lang")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigPaysLangRepository")
 */
class ConfigPaysLang
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
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigPays")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"fact_api"})
     */
    private $pays;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigLang")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lang;



    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     * @Groups({"fact_api"})
     */
    private $name;


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

    public function getTauxTva() {
        return $this->getPays()->getTauxTva();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ConfigPaysLang
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigPaysLang
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
     * @return ConfigPaysLang
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
     * @return ConfigPaysLang
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
     * @return ConfigPaysLang
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
     * @return ConfigPaysLang
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
     * Set lang
     *
     * @param \ConfigBundle\Entity\ConfigLang $lang
     *
     * @return ConfigPaysLang
     */
    public function setLang(\ConfigBundle\Entity\ConfigLang $lang = null)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return \ConfigBundle\Entity\ConfigLang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set pays
     *
     * @param \ConfigBundle\Entity\ConfigPays $pays
     *
     * @return ConfigPaysLang
     */
    public function setPays(\ConfigBundle\Entity\ConfigPays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \ConfigBundle\Entity\ConfigPays
     */
    public function getPays()
    {
        return $this->pays;
    }

    public function __toString(): ?string
    {
        return $this->getName();
    }

}
