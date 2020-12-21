<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockApprovisionnementDetail
 *
 * @ORM\Table(name="stock_approvisionnement_detail")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockApprovisionnementDetailRepository")
 */
class StockApprovisionnementDetail
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
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\StockApprovisionnement", inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $approvisionnement;

    /**
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\StockArticle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var int
     *
     * @ORM\Column(name="cout_achat_unitaire", type="integer")
     */
    private $coutAchatUnitaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;



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
     * Constructor
     */
    public function __construct()
    {
        $this->updatedAt = new \DateTime();
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return StockApprovisionnementDetail
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set coutAchatUnitaire
     *
     * @param integer $coutAchatUnitaire
     *
     * @return StockApprovisionnementDetail
     */
    public function setCoutAchatUnitaire($coutAchatUnitaire)
    {
        $this->coutAchatUnitaire = $coutAchatUnitaire;

        return $this;
    }

    /**
     * Get coutAchatUnitaire
     *
     * @return integer
     */
    public function getCoutAchatUnitaire()
    {
        return $this->coutAchatUnitaire;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return StockApprovisionnementDetail
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
     * Set approvisionnement
     *
     * @param \StockBundle\Entity\StockApprovisionnement $approvisionnement
     *
     * @return StockApprovisionnementDetail
     */
    public function setApprovisionnement(\StockBundle\Entity\StockApprovisionnement $approvisionnement)
    {
        $this->approvisionnement = $approvisionnement;

        return $this;
    }

    /**
     * Get approvisionnement
     *
     * @return \StockBundle\Entity\StockApprovisionnement
     */
    public function getApprovisionnement()
    {
        return $this->approvisionnement;
    }

    /**
     * Set article
     *
     * @param \StockBundle\Entity\StockArticle $article
     *
     * @return StockApprovisionnementDetail
     */
    public function setArticle(\StockBundle\Entity\StockArticle $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \StockBundle\Entity\StockArticle
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return StockApprovisionnementDetail
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
     * @return StockApprovisionnementDetail
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
     * @return StockApprovisionnementDetail
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
     * @return StockApprovisionnementDetail
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
