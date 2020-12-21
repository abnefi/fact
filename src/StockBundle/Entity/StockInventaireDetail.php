<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockInventaireDetail
 *
 * @ORM\Table(name="stock_inventaire_detail")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockInventaireDetailRepository")
 */
class StockInventaireDetail
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
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\StockInventaire", inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventaire;

    /**
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\StockArticle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var double
     *
     * @ORM\Column(name="stock_theorique", type="float")
     */
    private $stockTheorique;

    /**
     * @var double
     *
     * @ORM\Column(name="stock_reel", type="float")
     */
    private $stockReel;



    /**
     * @var \DateTime
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
     * Set stockTheorique
     *
     * @param float $stockTheorique
     *
     * @return StockInventaireDetail
     */
    public function setStockTheorique($stockTheorique)
    {
        $this->stockTheorique = $stockTheorique;

        return $this;
    }

    /**
     * Get stockTheorique
     *
     * @return float
     */
    public function getStockTheorique()
    {
        return $this->stockTheorique;
    }

    /**
     * Set stockReel
     *
     * @param float $stockReel
     *
     * @return StockInventaireDetail
     */
    public function setStockReel($stockReel)
    {
        $this->stockReel = $stockReel;

        return $this;
    }

    /**
     * Get stockReel
     *
     * @return float
     */
    public function getStockReel()
    {
        return $this->stockReel;
    }

    /**
     * Set inventaire
     *
     * @param \StockBundle\Entity\StockInventaire $inventaire
     *
     * @return StockInventaireDetail
     */
    public function setInventaire(\StockBundle\Entity\StockInventaire $inventaire)
    {
        $this->inventaire = $inventaire;

        return $this;
    }

    /**
     * Get inventaire
     *
     * @return \StockBundle\Entity\StockInventaire
     */
    public function getInventaire()
    {
        return $this->inventaire;
    }

    /**
     * Set article
     *
     * @param \StockBundle\Entity\StockArticle $article
     *
     * @return StockInventaireDetail
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
     * @return StockInventaireDetail
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
     * @return StockInventaireDetail
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
     * @return StockInventaireDetail
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
     * @return StockInventaireDetail
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
     * @return StockInventaireDetail
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
