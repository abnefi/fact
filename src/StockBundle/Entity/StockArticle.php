<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * StockArticle
 *
 * @ORM\Table(name="stock_article")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockArticleRepository")
 */
class StockArticle extends StockProduit
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
     * @var double
     * @ORM\Column(name="stockDisponible", type="float")
     */
    private $stockDisponible;

    /**
     * @var double
     * @Assert\NotBlank
     * @ORM\Column(name="stockAlerte", type="float")
     */
    private $stockAlerte;

    /**
     * @var double
     * @Assert\NotBlank
     * @ORM\Column(name="stockMinimum", type="float")
     */
    private $stockMinimum;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->stockDisponible = 0;
    }

//    /**
//     * @ORM\PreUpdate
//     */
//    public function updateDate()
//    {
//        $this->setUpdatedAt(new \Datetime());
//    }


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
     * Set stockDisponible
     *
     * @param float $stockDisponible
     *
     * @return StockArticle
     */
    public function setStockDisponible($stockDisponible)
    {
        $this->stockDisponible = $stockDisponible;

        return $this;
    }

    /**
     * Get stockDisponible
     *
     * @return float
     */
    public function getStockDisponible()
    {
        return $this->stockDisponible;
    }

    /**
     * Set stockAlerte
     *
     * @param float $stockAlerte
     *
     * @return StockArticle
     */
    public function setStockAlerte($stockAlerte)
    {
        $this->stockAlerte = $stockAlerte;

        return $this;
    }

    /**
     * Get stockAlerte
     *
     * @return float
     */
    public function getStockAlerte()
    {
        return $this->stockAlerte;
    }

    /**
     * Set stockMinimum
     *
     * @param float $stockMinimum
     *
     * @return StockArticle
     */
    public function setStockMinimum($stockMinimum)
    {
        $this->stockMinimum = $stockMinimum;

        return $this;
    }

    /**
     * Get stockMinimum
     *
     * @return float
     */
    public function getStockMinimum()
    {
        return $this->stockMinimum;
    }
}
