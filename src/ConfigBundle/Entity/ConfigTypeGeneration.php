<?php

namespace ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConfigTypeGeneration
 *
 * @ORM\Table(name="config_type_generation")
 * @ORM\Entity(repositoryClass="ConfigBundle\Repository\ConfigTypeGenerationRepository")
 */
class ConfigTypeGeneration
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
     * @ORM\Column(name="code", type="string", length=50,nullable=true)
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="code_societe", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $codeSociete;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="code_agence", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $codeAgence;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="code_fournisseur", type="string", length=4, nullable=true)
         * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $codeFournisseur;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="code_client", type="string", length=4, nullable=true)
         * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $codeClient;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="reference_article", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $referenceArticle;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="reference_service", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $referenceService;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="reference_approvisionnement", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $referenceApprovisionnement;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="reference_facture", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $referenceFacture;

    /**
     * @var string
     * @Assert\NotBlank(message="Champs obligatoire")
     * @ORM\Column(name="reference_inventaire", type="string", length=4, nullable=true)
     * @Assert\Length (max="4", maxMessage="Votre code ne doit pas dépasser 4 caracteres")
     */
    private $referenceInventaire;


    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=true)
     */
    private $societe;


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
     * @return ConfigTypeGeneration
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
     * @return ConfigTypeGeneration
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
     * Set estSupprimer
     *
     * @param boolean $estSupprimer
     *
     * @return ConfigTypeGeneration
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
     * Set codeAgence
     *
     * @param string $codeAgence
     *
     * @return ConfigTypeGeneration
     */
    public function setCodeAgence($codeAgence)
    {
        $this->codeAgence = $codeAgence;

        return $this;
    }

    /**
     * Get codeAgence
     *
     * @return string
     */
    public function getCodeAgence()
    {
        return $this->codeAgence;
    }

    /**
     * Set codeFournisseur
     *
     * @param string $codeFournisseur
     *
     * @return ConfigTypeGeneration
     */
    public function setCodeFournisseur($codeFournisseur)
    {
        $this->codeFournisseur = $codeFournisseur;

        return $this;
    }

    /**
     * Get codeFournisseur
     *
     * @return string
     */
    public function getCodeFournisseur()
    {
        return $this->codeFournisseur;
    }

    /**
     * Set codeClient
     *
     * @param string $codeClient
     *
     * @return ConfigTypeGeneration
     */
    public function setCodeClient($codeClient)
    {
        $this->codeClient = $codeClient;

        return $this;
    }

    /**
     * Get codeClient
     *
     * @return string
     */
    public function getCodeClient()
    {
        return $this->codeClient;
    }

    /**
     * Set referenceArticle
     *
     * @param string $referenceArticle
     *
     * @return ConfigTypeGeneration
     */
    public function setReferenceArticle($referenceArticle)
    {
        $this->referenceArticle = $referenceArticle;

        return $this;
    }

    /**
     * Get referenceArticle
     *
     * @return string
     */
    public function getReferenceArticle()
    {
        return $this->referenceArticle;
    }

    /**
     * Set referenceService
     *
     * @param string $referenceService
     *
     * @return ConfigTypeGeneration
     */
    public function setReferenceService($referenceService)
    {
        $this->referenceService = $referenceService;

        return $this;
    }

    /**
     * Get referenceService
     *
     * @return string
     */
    public function getReferenceService()
    {
        return $this->referenceService;
    }

    /**
     * Set referenceApprovisionnement
     *
     * @param string $referenceApprovisionnement
     *
     * @return ConfigTypeGeneration
     */
    public function setReferenceApprovisionnement($referenceApprovisionnement)
    {
        $this->referenceApprovisionnement = $referenceApprovisionnement;

        return $this;
    }

    /**
     * Get referenceApprovisionnement
     *
     * @return string
     */
    public function getReferenceApprovisionnement()
    {
        return $this->referenceApprovisionnement;
    }

    /**
     * Set referenceFacture
     *
     * @param string $referenceFacture
     *
     * @return ConfigTypeGeneration
     */
    public function setReferenceFacture($referenceFacture)
    {
        $this->referenceFacture = $referenceFacture;

        return $this;
    }

    /**
     * Get referenceFacture
     *
     * @return string
     */
    public function getReferenceFacture()
    {
        return $this->referenceFacture;
    }

    /**
     * Set referenceInventaire
     *
     * @param string $referenceInventaire
     *
     * @return ConfigTypeGeneration
     */
    public function setReferenceInventaire($referenceInventaire)
    {
        $this->referenceInventaire = $referenceInventaire;

        return $this;
    }

    /**
     * Get referenceInventaire
     *
     * @return string
     */
    public function getReferenceInventaire()
    {
        return $this->referenceInventaire;
    }


    /**
     * Set codeSociete
     *
     * @param string $codeSociete
     *
     * @return ConfigTypeGeneration
     */
    public function setCodeSociete($codeSociete)
    {
        $this->codeSociete = $codeSociete;

        return $this;
    }

    /**
     * Get codeSociete
     *
     * @return string
     */
    public function getCodeSociete()
    {
        return $this->codeSociete;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ConfigTypeGeneration
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
     * @return ConfigTypeGeneration
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
     * @return ConfigTypeGeneration
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
     * @return ConfigTypeGeneration
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
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return ConfigTypeGeneration
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


    public function __toString(): ?string
    {
        return $this->getLibelle();
    }
}
