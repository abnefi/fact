<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockService
 *
 * @ORM\Table(name="stock_service")
 * @ORM\Entity(repositoryClass="StockBundle\Repository\StockServiceRepository")
 */
class StockService extends StockProduit
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
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigUniteMesure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $uniteMesure;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Set uniteMesure
     *
     * @param \ConfigBundle\Entity\ConfigUniteMesure $uniteMesure
     *
     * @return StockService
     */
    public function setUniteMesure(\ConfigBundle\Entity\ConfigUniteMesure $uniteMesure = null)
    {
        $this->uniteMesure = $uniteMesure;

        return $this;
    }

    /**
     * Get uniteMesure
     *
     * @return \ConfigBundle\Entity\ConfigUniteMesure
     */
    public function getUniteMesure()
    {
        return $this->uniteMesure;
    }
}
