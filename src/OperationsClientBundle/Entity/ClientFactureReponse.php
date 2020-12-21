<?php

namespace OperationsClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientFactureReponse
 *
 * @ORM\Table(name="client_facture_reponse")
 * @ORM\Entity(repositoryClass="OperationsClientBundle\Repository\ClientFactureReponseRepository")
 */
class ClientFactureReponse
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
     * @ORM\Column(name="reference_facture", type="string", length=255)
     */
    private $referenceFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="compteur_type_facture", type="integer")
     */
    private $compteurTypeFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="compteur_total", type="integer")
     */
    private $compteurTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="date_heure", type="string", length=50)
     */
    private $dateHeure;

    /**
     * @var string
     *
     * @ORM\Column(name="sig", type="string", length=100)
     */
    private $sig;

    /**
     * @var string
     *
     * @ORM\Column(name="code_qr", type="string", length=255)
     */
    private $codeQR;


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
     * Set referenceFacture
     *
     * @param string $referenceFacture
     *
     * @return ClientFactureReponse
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
     * Set compteurTypeFacture
     *
     * @param integer $compteurTypeFacture
     *
     * @return ClientFactureReponse
     */
    public function setCompteurTypeFacture($compteurTypeFacture)
    {
        $this->compteurTypeFacture = $compteurTypeFacture;

        return $this;
    }

    /**
     * Get compteurTypeFacture
     *
     * @return integer
     */
    public function getCompteurTypeFacture()
    {
        return $this->compteurTypeFacture;
    }

    /**
     * Set compteurTotal
     *
     * @param integer $compteurTotal
     *
     * @return ClientFactureReponse
     */
    public function setCompteurTotal($compteurTotal)
    {
        $this->compteurTotal = $compteurTotal;

        return $this;
    }

    /**
     * Get compteurTotal
     *
     * @return integer
     */
    public function getCompteurTotal()
    {
        return $this->compteurTotal;
    }

    /**
     * Set dateHeure
     *
     * @param string $dateHeure
     *
     * @return ClientFactureReponse
     */
    public function setDateHeure($dateHeure)
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    /**
     * Get dateHeure
     *
     * @return string
     */
    public function getDateHeure()
    {
        return $this->dateHeure;
    }

    /**
     * Set sig
     *
     * @param string $sig
     *
     * @return ClientFactureReponse
     */
    public function setSig($sig)
    {
        $this->sig = $sig;

        return $this;
    }

    /**
     * Get sig
     *
     * @return string
     */
    public function getSig()
    {
        return $this->sig;
    }

    /**
     * Set codeQR
     *
     * @param string $codeQR
     *
     * @return ClientFactureReponse
     */
    public function setCodeQR($codeQR)
    {
        $this->codeQR = $codeQR;

        return $this;
    }

    /**
     * Get codeQR
     *
     * @return string
     */
    public function getCodeQR()
    {
        return $this->codeQR;
    }

    /**
     * Set created
     *
     * @param \datetime $created
     *
     * @return ClientFactureReponse
     */
    public function setCreated(\datetime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \datetime
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
     * @return ClientFactureReponse
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
     * @return ClientFactureReponse
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
     * @return ClientFactureReponse
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
     * @return ClientFactureReponse
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
