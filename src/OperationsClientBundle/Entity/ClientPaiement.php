<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClientPaiement
 *
 * @ORM\Table(name="client_paiement")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientPaiementRepository")
 */
class ClientPaiement
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
     * @ORM\ManyToOne(targetEntity="OperationsClientBundle\Entity\ClientFacture", inversedBy="paiements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

    /**
     * @var \DateTime
     * @Assert\NotBlank
     * @ORM\Column(name="date_paiement", type="date")
     */
    private $datePaiement;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigModePaiement")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"fact_api"})
     */
    private $modePaiement;

    /**
     * @var double
     * @Assert\NotBlank
     * @ORM\Column(name="montant", type="float")
     * @Groups({"fact_api"})
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     * @ORM\Column(name="createdBy", type="string", length=255)
     */
    private $createdBy;

    /**
     * @var string
     * @ORM\Column(name="updateBy", type="string", length=255, nullable=true)
     */
    private $updateBy;

    /**
     * @var string
     *
     * @ORM\Column(name="userPublicId", type="string", length=50, nullable=true)
     */
    private $userPublicId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="supprimer", type="boolean")
     */
    private $supprimer;


    /**
     * @var string
     *
     * @ORM\Column(name="referenceComptable", type="text", nullable=true)
     */
    private $referenceComptable;


    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->supprimer = false;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
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
     * Set datePaiement
     *
     * @param \DateTime $datePaiement
     *
     * @return ClientPaiement
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    /**
     * Get datePaiement
     *
     * @return \DateTime
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return ClientPaiement
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ClientPaiement
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return ClientPaiement
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set userPublicId
     *
     * @param string $userPublicId
     *
     * @return ClientPaiement
     */
    public function setUserPublicId($userPublicId)
    {
        $this->userPublicId = $userPublicId;

        return $this;
    }

    /**
     * Get userPublicId
     *
     * @return string
     */
    public function getUserPublicId()
    {
        return $this->userPublicId;
    }

    /**
     * Set supprimer
     *
     * @param boolean $supprimer
     *
     * @return ClientPaiement
     */
    public function setSupprimer($supprimer)
    {
        $this->supprimer = $supprimer;

        return $this;
    }

    /**
     * Get supprimer
     *
     * @return boolean
     */
    public function getSupprimer()
    {
        return $this->supprimer;
    }

    /**
     * Set facture
     *
     * @param \OperationsClientBundle\Entity\ClientFacture $facture
     *
     * @return ClientPaiement
     */
    public function setFacture(\OperationsClientBundle\Entity\ClientFacture $facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \OperationsClientBundle\Entity\ClientFacture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set modePaiement
     *
     * @param \ConfigBundle\Entity\ConfigModePaiement $modePaiement
     *
     * @return ClientPaiement
     */
    public function setModePaiement(\ConfigBundle\Entity\ConfigModePaiement $modePaiement)
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    /**
     * Get modePaiement
     *
     * @return \ConfigBundle\Entity\ConfigModePaiement
     */
    public function getModePaiement()
    {
        return $this->modePaiement;
    }

    /**
     * Set referenceComptable
     *
     * @param string $referenceComptable
     *
     * @return ClientPaiement
     */
    public function setReferenceComptable($referenceComptable)
    {
        $this->referenceComptable = $referenceComptable;

        return $this;
    }

    /**
     * Get referenceComptable
     *
     * @return string
     */
    public function getReferenceComptable()
    {
        return $this->referenceComptable;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return ClientPaiement
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
     * Set updateBy
     *
     * @param string $updateBy
     *
     * @return ClientPaiement
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
     * @return ClientPaiement
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
