<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientDevisExportation
 *
 * @ORM\Table(name="client_devis_exportation")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientDevisExportationRepository")
 */
class ClientDevisExportation extends ClientFacture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    //Champ valable uniquement pour les devis (ou factures pro-forma). Il s'agit de la référence à renseigner si le devis est transformé
    //en facture de vente
    /**
     * @var string
     *
     * @ORM\Column(name="reference_facture_vente_genere", type="string", length=255, nullable=true)
     */
    private $referenceFactureVenteGenere;


    /**
     * Set referenceFactureVenteGenere
     *
     * @param string $referenceFactureVenteGenere
     *
     * @return ClientDevisExportation
     */
    public function setReferenceFactureVenteGenere($referenceFactureVenteGenere)
    {
        $this->referenceFactureVenteGenere = $referenceFactureVenteGenere;

        return $this;
    }

    /**
     * Get referenceFactureVenteGenere
     *
     * @return string
     */
    public function getReferenceFactureVenteGenere()
    {
        return $this->referenceFactureVenteGenere;
    }

    /**
     * Set idLocal
     *
     * @param integer $idLocal
     *
     * @return ClientDevisExportation
     */
    public function setIdLocal($idLocal)
    {
        $this->idLocal = $idLocal;

        return $this;
    }

    /**
     * Get idLocal
     *
     * @return integer
     */
    public function getIdLocal()
    {
        return $this->idLocal;
    }
}
