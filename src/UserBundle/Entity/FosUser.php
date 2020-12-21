<?php

namespace UserBundle\Entity;
/*use Symfony\Component\String\Slugger\SluggerInterface;*/

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FosUser
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\FosUserRepository")
 */
class FosUser extends BaseUser implements UserInterface
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
     * @var string
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de chiffre"
     * )
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de chiffre"
     * )
     * @ORM\Column(name="prenoms", type="string", length=255,nullable=true)
     */
    private $prenoms;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @Gedmo\Slug(fields={"nom","prenoms","created"})
     * @ORM\Column(length=255, unique=true, nullable=true)
     */
    private $slug;

    /**
     * @var bool
     * @ORM\Column(name="est_veririfer", type="boolean")
     */
    private $estVerifier;

    /**
     *
     * @ORM\Column(name="created", type="datetime",nullable=true)
     */

    private $created;


    /**
     * @var string
     * @ORM\Column(name="createdBy", type="string", length=255, nullable=true)
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
     * @var string
     * @ORM\Column(name="userPublicId", type="string", length=50, nullable=true)
     */
    private $userPublicId;


    /**
     * @var bool
     *
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_activer", type="boolean")
     */
    private $estActiver;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigAgence")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agence;

    public function __construct()
    {
        parent::__construct();
        $this->created = new \DateTime();
        $this->createdBy = $this->getNom().' '.$this->getPrenoms();
        $this->estVerifier = 0;
        $this->estSupprimer = 0;
        $this->estActiver = 0;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return FosUser
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenoms
     *
     * @param string $prenoms
     *
     * @return FosUser
     */
    public function setPrenoms($prenoms)
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    /**
     * Get prenoms
     *
     * @return string
     */
    public function getPrenoms()
    {
        return $this->prenoms;
    }

    /**
     * Set userPublicId
     *
     * @param string $userPublicId
     *
     * @return FosUser
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
     * Set agence
     *
     * @param \ConfigBundle\Entity\ConfigAgence $agence
     *
     * @return FosUser
     */
    public function setAgence(\ConfigBundle\Entity\ConfigAgence $agence = null)
    {
        $this->agence = $agence;

        return $this;
    }


    /**
     * Get agence
     *
     * @return \ConfigBundle\Entity\ConfigAgence
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return FosUser
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return FosUser
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
     * @see UserInterface
     */
    public function getSalt()
    {
        //
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        //
    }

    /**
     * Set estVerifier
     *
     * @param boolean $estVerifier
     *
     * @return FosUser
     */
    public function setEstVerifier($estVerifier)
    {
        $this->estVerifier = $estVerifier;

        return $this;
    }

    /**
     * Get estVerifier
     *
     * @return boolean
     */
    public function getEstVerifier()
    {
        return $this->estVerifier;
    }

    /**
     * Set estActiver
     *
     * @param boolean $estActiver
     *
     * @return FosUser
     */
    public function setEstActiver($estActiver)
    {
        $this->estActiver = $estActiver;

        return $this;
    }

    /**
     * Get estActiver
     *
     * @return boolean
     */
    public function getEstActiver()
    {
        return $this->estActiver;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return FosUser
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
     * @return FosUser
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
     * @return FosUser
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
     * @return FosUser
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
