<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockApprovisionnement
 *
 * @ORM\Table(name="stock_approvisionnement")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockApprovisionnementRepository")
 */
class StockApprovisionnement
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
     * @ORM\Column(name="reference", type="string", length=50, unique=true)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="TiersBundle\Entity\TiersFournisseur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reception", type="date")
     */
    private $dateReception;

    /**
     * @ORM\OneToMany(targetEntity="StockBundle\Entity\StockApprovisionnementDetail", mappedBy="approvisionnement",
     *  fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     */
    private $details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
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
     * @var bool
     *
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;


    /**
     * @var string
     *
     * @ORM\Column(name="userPublicId", type="string", length=50, nullable=true)
     */
    private $userPublicId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->details = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set reference
     *
     * @param string $reference
     *
     * @return StockApprovisionnement
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set dateReception
     *
     * @param \DateTime $dateReception
     *
     * @return StockApprovisionnement
     */
    public function setDateReception($dateReception)
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    /**
     * Get dateReception
     *
     * @return \DateTime
     */
    public function getDateReception()
    {
        return $this->dateReception;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return StockApprovisionnement
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
     * @return StockApprovisionnement
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
     * @return StockApprovisionnement
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
     * Set fournisseur
     *
     * @param \TiersBundle\Entity\TiersFournisseur $fournisseur
     *
     * @return StockApprovisionnement
     */
    public function setFournisseur(\TiersBundle\Entity\TiersFournisseur $fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \TiersBundle\Entity\TiersFournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return StockApprovisionnement
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
     * Add detail
     *
     * @param \StockBundle\Entity\StockApprovisionnementDetail $detail
     *
     * @return StockApprovisionnement
     */
    public function addDetail(\StockBundle\Entity\StockApprovisionnementDetail $detail)
    {
        $detail->setApprovisionnement($this);
        $this->details[] = $detail;

        return $this;
    }

    /**
     * Remove detail
     *
     * @param \StockBundle\Entity\StockApprovisionnementDetail $detail
     */
    public function removeDetail(\StockBundle\Entity\StockApprovisionnementDetail $detail)
    {
        $this->details->removeElement($detail);
        $detail->setApprovisionnement(null);
    }

    /**
     * Get details
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return StockApprovisionnement
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
     * @return StockApprovisionnement
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
     * @return StockApprovisionnement
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
