<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConfigSociete
 *
 * @ORM\Table(name="config_societe")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigSocieteRepository")
 */
class ConfigSociete
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
     * @ORM\Column(name="code", type="string", length=100, unique=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigBanque")
     * @ORM\JoinColumn(name="banque",nullable=false)
     */
    private $banque;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="raisonSociale", type="string", length=255, unique=true)
     * @Groups({"fact_api"})
     */
    private $raisonSociale;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="ifu_file", type="string", length=255)
     */
    private $ifuFile;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="registre_file", type="string", length=255)
     */
    private $registreFile;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="telephone", type="string", length=50)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Champ requis")
     * @ORM\Column(name="registreCommerce", type="string", length=100)
     */
    private $registreCommerce;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @Assert\Length(min="13", minMessage="Entrer au minimum 13 caracteres")
     * @Assert\Length(max="13", maxMessage="Entrer au maximum 13 caracteres")
     * @ORM\Column(name="ifu", type="string", length=15, unique=true)
     * @Groups({"fact_api"})
     */
    private $ifu;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="fonctionRepresentant", type="string", length=255)
     */
    private $fonctionRepresentant;

    /**
     * @var string
     *
     * @ORM\Column(name="formeJuridique", type="string", length=50, nullable=true)
     */
    private $formeJuridique;

    /**
     * @var int
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="capital", type="integer", length=20, nullable=true)
     */
    private $capital;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigPaysLang", cascade={"persist", "remove"})
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="rib", type="string", length=100)
     */
    private $rib;

    /**
     * @var string
     *
     * @Assert\Url(
     *     message="Url invalide",
     *     protocols={"http", "https", "ftp"}
     * )
     * @ORM\Column(name="site_web", type="string", length=100, nullable=true)
     */
    private $siteWeb;

    /**
     * @var bool
     *
     * @ORM\Column(name="assujetiTva", type="boolean")
     * @Groups({"fact_api"})
     */
    private $assujetiTva;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_actif", type="boolean")
     */
    private $estActif;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_Profession_Liberale", type="boolean")
     * @Groups({"fact_api"})
     */
    private $estProfessionLiberale;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="type_entreprise", type="string")
     */
    private $typeEntreprise;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="ville", type="string")
     */
    private $ville;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="prenom", type="string")
     */
    private $prenom;

    /**
     * @var bool
     *
     * @ORM\Column(name="exportation", type="boolean")
     */
    private $exportation;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigTypeActivite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeActivite;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigDevise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devise;

    /**
     * @ORM\OneToMany(targetEntity="ConfigBundle\Entity\ConfigAgence", mappedBy="societe",
     *  fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     */
    private $agences;

    /**
     * @ORM\OneToMany(targetEntity="ConfigBundle\Entity\ConfigAbonnementSociete", mappedBy="societe")
     *  @ORM\JoinColumn(nullable=true)
     */
    private $abonnement;


    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

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

// Attribut pour verifier si l'abonnement est deja essayer une fois
    /**
     * @var bool
     *
     * @ORM\Column(name="deja_essayer", type="boolean", nullable=true)
     */
    private $dejaEssayer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estSupprimer = 0;
        $this->estActif = false;
        $this->assujetiTva = false;
        $this->exportation = false;
        $this->estProfessionLiberale = false;
        $this->agences = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created = new \DateTime();
        $this->updateAt = new \DateTime();
        $this->estProfessionLiberale = 0;
        $this->dejaEssayer = 0;
    }



    public function __toString(): ?string
    {
        return $this->getCode();
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
     * @return ConfigSociete
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
     * Set raisonSociale
     *
     * @param string $raisonSociale
     *
     * @return ConfigSociete
     */
    public function setRaisonSociale($raisonSociale)
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Get raisonSociale
     *
     * @return string
     */
    public function getRaisonSociale()
    {
        return $this->raisonSociale;
    }

    /**
     * Set ifuFile
     *
     * @param string $ifuFile
     *
     * @return ConfigSociete
     */
    public function setIfuFile($ifuFile)
    {
        $this->ifuFile = $ifuFile;

        return $this;
    }

    /**
     * Get ifuFile
     *
     * @return string
     */
    public function getIfuFile()
    {
        return $this->ifuFile;
    }

    /**
     * Set registreFile
     *
     * @param string $registreFile
     *
     * @return ConfigSociete
     */
    public function setRegistreFile($registreFile)
    {
        $this->registreFile = $registreFile;

        return $this;
    }

    /**
     * Get registreFile
     *
     * @return string
     */
    public function getRegistreFile()
    {
        return $this->registreFile;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return ConfigSociete
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return ConfigSociete
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
     * Set email
     *
     * @param string $email
     *
     * @return ConfigSociete
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set registreCommerce
     *
     * @param string $registreCommerce
     *
     * @return ConfigSociete
     */
    public function setRegistreCommerce($registreCommerce)
    {
        $this->registreCommerce = $registreCommerce;

        return $this;
    }

    /**
     * Get registreCommerce
     *
     * @return string
     */
    public function getRegistreCommerce()
    {
        return $this->registreCommerce;
    }

    /**
     * Set ifu
     *
     * @param string $ifu
     *
     * @return ConfigSociete
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
     * Set fonctionRepresentant
     *
     * @param string $fonctionRepresentant
     *
     * @return ConfigSociete
     */
    public function setFonctionRepresentant($fonctionRepresentant)
    {
        $this->fonctionRepresentant = $fonctionRepresentant;

        return $this;
    }

    /**
     * Get fonctionRepresentant
     *
     * @return string
     */
    public function getFonctionRepresentant()
    {
        return $this->fonctionRepresentant;
    }

    /**
     * Set formeJuridique
     *
     * @param string $formeJuridique
     *
     * @return ConfigSociete
     */
    public function setFormeJuridique($formeJuridique)
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    /**
     * Get formeJuridique
     *
     * @return string
     */
    public function getFormeJuridique()
    {
        return $this->formeJuridique;
    }

    /**
     * Set capital
     *
     * @param integer $capital
     *
     * @return ConfigSociete
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get capital
     *
     * @return integer
     */
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * Set rib
     *
     * @param string $rib
     *
     * @return ConfigSociete
     */
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get rib
     *
     * @return string
     */
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return ConfigSociete
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set assujetiTva
     *
     * @param boolean $assujetiTva
     *
     * @return ConfigSociete
     */
    public function setAssujetiTva($assujetiTva)
    {
        $this->assujetiTva = $assujetiTva;

        return $this;
    }

    /**
     * Get assujetiTva
     *
     * @return boolean
     */
    public function getAssujetiTva()
    {
        return $this->assujetiTva;
    }

    /**
     * Set estActif
     *
     * @param boolean $estActif
     *
     * @return ConfigSociete
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
     * Set estProfessionLiberale
     *
     * @param boolean $estProfessionLiberale
     *
     * @return ConfigSociete
     */
    public function setEstProfessionLiberale($estProfessionLiberale)
    {
        $this->estProfessionLiberale = $estProfessionLiberale;

        return $this;
    }

    /**
     * Get estProfessionLiberale
     *
     * @return boolean
     */
    public function getEstProfessionLiberale()
    {
        return $this->estProfessionLiberale;
    }

    /**
     * Set typeEntreprise
     *
     * @param string $typeEntreprise
     *
     * @return ConfigSociete
     */
    public function setTypeEntreprise($typeEntreprise)
    {
        $this->typeEntreprise = $typeEntreprise;

        return $this;
    }

    /**
     * Get typeEntreprise
     *
     * @return string
     */
    public function getTypeEntreprise()
    {
        return $this->typeEntreprise;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return ConfigSociete
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
     * Set nom
     *
     * @param string $nom
     *
     * @return ConfigSociete
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return ConfigSociete
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set exportation
     *
     * @param boolean $exportation
     *
     * @return ConfigSociete
     */
    public function setExportation($exportation)
    {
        $this->exportation = $exportation;

        return $this;
    }

    /**
     * Get exportation
     *
     * @return boolean
     */
    public function getExportation()
    {
        return $this->exportation;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return ConfigSociete
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigSociete
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
     * @return ConfigSociete
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
     * @return ConfigSociete
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
     * @return ConfigSociete
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
     * @return ConfigSociete
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
     * Set banque
     *
     * @param \ConfigBundle\Entity\ConfigBanque $banque
     *
     * @return ConfigSociete
     */
    public function setBanque(\ConfigBundle\Entity\ConfigBanque $banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return \ConfigBundle\Entity\ConfigBanque
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set pays
     *
     * @param \ConfigBundle\Entity\ConfigPaysLang $pays
     *
     * @return ConfigSociete
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

    /**
     * Set typeActivite
     *
     * @param \ConfigBundle\Entity\ConfigTypeActivite $typeActivite
     *
     * @return ConfigSociete
     */
    public function setTypeActivite(\ConfigBundle\Entity\ConfigTypeActivite $typeActivite = null)
    {
        $this->typeActivite = $typeActivite;

        return $this;
    }

    /**
     * Get typeActivite
     *
     * @return \ConfigBundle\Entity\ConfigTypeActivite
     */
    public function getTypeActivite()
    {
        return $this->typeActivite;
    }

    /**
     * Set devise
     *
     * @param \ConfigBundle\Entity\ConfigDevise $devise
     *
     * @return ConfigSociete
     */
    public function setDevise(\ConfigBundle\Entity\ConfigDevise $devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return \ConfigBundle\Entity\ConfigDevise
     */
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Add agence
     *
     * @param \ConfigBundle\Entity\ConfigAgence $agence
     *
     * @return ConfigSociete
     */
    public function addAgence(\ConfigBundle\Entity\ConfigAgence $agence)
    {
        $this->agences[] = $agence;

        return $this;
    }

    /**
     * Remove agence
     *
     * @param \ConfigBundle\Entity\ConfigAgence $agence
     */
    public function removeAgence(\ConfigBundle\Entity\ConfigAgence $agence)
    {
        $this->agences->removeElement($agence);
    }

    /**
     * Get agences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAgences()
    {
        return $this->agences;
    }

    /**
     * Add abonnement
     *
     * @param \ConfigBundle\Entity\ConfigAbonnementSociete $abonnement
     *
     * @return ConfigSociete
     */
    public function addAbonnement(\ConfigBundle\Entity\ConfigAbonnementSociete $abonnement)
    {
        $this->abonnement[] = $abonnement;

        return $this;
    }

    /**
     * Remove abonnement
     *
     * @param \ConfigBundle\Entity\ConfigAbonnementSociete $abonnement
     */
    public function removeAbonnement(\ConfigBundle\Entity\ConfigAbonnementSociete $abonnement)
    {
        $this->abonnement->removeElement($abonnement);
    }

    /**
     * Get abonnement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * Set dejaEssayer
     *
     * @param boolean $dejaEssayer
     *
     * @return ConfigSociete
     */
    public function setDejaEssayer($dejaEssayer)
    {
        $this->dejaEssayer = $dejaEssayer;

        return $this;
    }

    /**
     * Get dejaEssayer
     *
     * @return boolean
     */
    public function getDejaEssayer()
    {
        return $this->dejaEssayer;
    }
}
