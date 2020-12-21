<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSociete
 *
 * @ORM\Table(name="user_societe")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserSocieteRepository")
 */
class UserSociete
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="UserPublicId", type="string", length=255)
//     */
//    private $userPublicId;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\FosUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigBundle\Entity\ConfigAgence")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
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
     * @var boolean
     *
     * @ORM\Column(name="supprimer", type="boolean")
     */
    private $supprimer;

    public function __construct()
    {
        $this->supprimer = 0;
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
     * Set supprimer
     *
     * @param boolean $supprimer
     *
     * @return UserSociete
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
     * Set user
     *
     * @param \UserBundle\Entity\FosUser $user
     *
     * @return UserSociete
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
     * Set agence
     *
     * @param \ConfigBundle\Entity\ConfigAgence $agence
     *
     * @return UserSociete
     */
    public function setAgence(\ConfigBundle\Entity\ConfigAgence $agence)
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return UserSociete
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
     * @return UserSociete
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
     * @return UserSociete
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
     * @return UserSociete
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
