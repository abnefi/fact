<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAgence
 *
 * @ORM\Table(name="user_agence")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserAgenceRepository")
 */
class UserAgence
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
     * Set user
     *
     * @param \UserBundle\Entity\FosUser $user
     *
     * @return UserAgence
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
     * @return UserAgence
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
     * @return UserAgence
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
     * @return UserAgence
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
     * @param \DateTime $updateAt
     *
     * @return UserAgence
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
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
     * @return UserAgence
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
     * @return UserAgence
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
