<?php

namespace StockBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * StockInventaire
 *
 * @ORM\Table(name="stock_inventaire")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockInventaireRepository")
 */
class StockInventaire
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
     * @ORM\Column(name="reference_inventaire", type="string", length=255, unique=true)
     */
    private $referenceInventaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inventaire", type="date")
     */
    private $dateInventaire;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigEtat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_valide", type="boolean")
     */
    private $estValide;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_annule", type="boolean")
     */
    private $estAnnule;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_supprime", type="boolean")
     */
    private $estSupprime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_validation", type="date", nullable=true)
     */
    private $dateValidation;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\FosUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime
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
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigSociete")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     * @ORM\OneToMany(targetEntity="StockBundle\Entity\StockInventaireDetail", mappedBy="inventaire",
     *  fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     */
    private $details;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estValide = false;
        $this->estAnnule = false;
        $this->estSupprime = false;
        $this->created = new \Datetime();
        $this->updatedAt = new \Datetime();
        $this->details = new ArrayCollection();
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
     * Set referenceInventaire
     *
     * @param string $referenceInventaire
     *
     * @return StockInventaire
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
     * Set dateInventaire
     *
     * @param \DateTime $dateInventaire
     *
     * @return StockInventaire
     */
    public function setDateInventaire($dateInventaire)
    {
        $this->dateInventaire = $dateInventaire;

        return $this;
    }

    /**
     * Get dateInventaire
     *
     * @return \DateTime
     */
    public function getDateInventaire()
    {
        return $this->dateInventaire;
    }

    /**
     * Set estValide
     *
     * @param boolean $estValide
     *
     * @return StockInventaire
     */
    public function setEstValide($estValide)
    {
        $this->estValide = $estValide;

        return $this;
    }

    /**
     * Get estValide
     *
     * @return boolean
     */
    public function getEstValide()
    {
        return $this->estValide;
    }

    /**
     * Set estAnnule
     *
     * @param boolean $estAnnule
     *
     * @return StockInventaire
     */
    public function setEstAnnule($estAnnule)
    {
        $this->estAnnule = $estAnnule;

        return $this;
    }

    /**
     * Get estAnnule
     *
     * @return boolean
     */
    public function getEstAnnule()
    {
        return $this->estAnnule;
    }

    /**
     * Set estSupprime
     *
     * @param boolean $estSupprime
     *
     * @return StockInventaire
     */
    public function setEstSupprime($estSupprime)
    {
        $this->estSupprime = $estSupprime;

        return $this;
    }

    /**
     * Get estSupprime
     *
     * @return boolean
     */
    public function getEstSupprime()
    {
        return $this->estSupprime;
    }

    /**
     * Set dateValidation
     *
     * @param \DateTime $dateValidation
     *
     * @return StockInventaire
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    /**
     * Get dateValidation
     *
     * @return \DateTime
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return StockInventaire
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
     * @return StockInventaire
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
     * Set etat
     *
     * @param \ConfigBundle\Entity\ConfigEtat $etat
     *
     * @return StockInventaire
     */
    public function setEtat(\ConfigBundle\Entity\ConfigEtat $etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \ConfigBundle\Entity\ConfigEtat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\FosUser $user
     *
     * @return StockInventaire
     */
    public function setUser(\UserBundle\Entity\FosUser $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\FosUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set societe
     *
     * @param \ConfigBundle\Entity\ConfigSociete $societe
     *
     * @return StockInventaire
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
     * @param \StockBundle\Entity\StockInventaireDetail $detail
     *
     * @return StockInventaire
     */
    public function addDetail(\StockBundle\Entity\StockInventaireDetail $detail)
    {
        $this->details[] = $detail;

        return $this;
    }

    /**
     * Remove detail
     *
     * @param \StockBundle\Entity\StockInventaireDetail $detail
     */
    public function removeDetail(\StockBundle\Entity\StockInventaireDetail $detail)
    {
        $this->details->removeElement($detail);
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
     * @return StockInventaire
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
     * @return StockInventaire
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
}
