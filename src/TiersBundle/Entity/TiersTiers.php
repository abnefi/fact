<?php

namespace TiersBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * TiersTiers
 *
 * @ORM\Table(name="tiers_tiers")
 * @ORM\Entity(repositoryClass="TiersBundle\Repository\TiersTiersRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"tiersFournisseur" = "TiersFournisseur", "tiersClient"="TiersClient"})
 * @UniqueEntity(fields={"nom"}, message="Un compte est deja associe à cet nom")
 * @UniqueEntity(fields={"ifu"}, message="Ce numéro ifu existe déjà")
 */
abstract class TiersTiers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=20)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     * @Groups({"fact_api"})
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     * @Assert\Email(message="E-mail invalide")
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    private $mail;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length (min="8", minMessage="Entrer au minimum 8 caracteres")
     * @Assert\Length (max="18", maxMessage="Entrer au maximum 16 caracteres")
     * @ORM\Column(name="telephone", type="string", length=50)
     */
    private $telephone;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="ifu", type="string", length=50, nullable=true, unique=true)
     * @Assert\Length (min="13", minMessage="Entrer au minimum 13 caracteres")
     * @Assert\Length (max="13", maxMessage="Entrer au maximum 13 caracteres")
     * @Groups({"fact_api"})
     */
    private $ifu;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigPaysLang", cascade={"persist", "remove"})
     * @Groups({"fact_api"})
     */
    private $pays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var string
     * @ORM\Column(name="createdBy", type="string", length=255, nullable=true)
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


    public function __construct()
    {
        $this->ifu = '';
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
     * @return TiersTiers
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
     * Set nom
     *
     * @param string $nom
     *
     * @return TiersTiers
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return TiersTiers
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return TiersTiers
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return TiersTiers
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set ifu
     *
     * @param string $ifu
     *
     * @return TiersTiers
     */
    public function setIfu($ifu)
    {
        $this->ifu = $ifu;

        return $this;
    }

    /**
     * Get ifu
     *
     * @return string
     */
    public function getIfu()
    {
        return $this->ifu;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return TiersTiers
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
     * @return TiersTiers
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
     * @return TiersTiers
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
     * @return TiersTiers
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
     * @return TiersTiers
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
     * @return TiersTiers
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
     * Set pays
     *
     * @param \ConfigBundle\Entity\ConfigPaysLang $pays
     *
     * @return TiersTiers
     */
    public function setPays(\ConfigBundle\Entity\ConfigPaysLang $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \ConfigBundle\Entity\ConfigPaysLang
     */
    public function getPays()
    {
        return $this->pays;
    }
}
