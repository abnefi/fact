<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserMouchard
 *
 * @ORM\Table(name="user_mouchard")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserMouchardRepository")
 */
class UserMouchard
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_action", type="datetime")
     */
    private $dateAction;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_name", type="string", length=255,nullable=true)
     */
    private $entityName;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer",nullable=true)
     */
    private $entityId;

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
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;


    /**
     * @var string
     *
     * @ORM\Column(name="code_app", type="string", length=255)
     */
    private $codeApp;

    /**
     * @var boolean
     *
     * @ORM\Column(name="est_recupere", type="boolean",nullable=true)
     */
    private $estrecupere;


    /**
     * @var bool
     *
     * @ORM\Column(name="estSupprimer", type="boolean")
     */
    private $estSupprimer;


    public function __construct()
    {
        $this->estrecupere = false;
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
     * Set dateAction
     *
     * @param \DateTime $dateAction
     *
     * @return UserMouchard
     */
    public function setDateAction($dateAction)
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    /**
     * Get dateAction
     *
     * @return \DateTime
     */
    public function getDateAction()
    {
        return $this->dateAction;
    }

    /**
     * Set entityName
     *
     * @param string $entityName
     *
     * @return UserMouchard
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * Get entityName
     *
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     *
     * @return UserMouchard
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return UserMouchard
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
     * Set username
     *
     * @param string $username
     *
     * @return UserMouchard
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return UserMouchard
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return UserMouchard
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set codeApp
     *
     * @param string $codeApp
     *
     * @return UserMouchard
     */
    public function setCodeApp($codeApp)
    {
        $this->codeApp = $codeApp;

        return $this;
    }

    /**
     * Get codeApp
     *
     * @return string
     */
    public function getCodeApp()
    {
        return $this->codeApp;
    }

    /**
     * Set estrecupere
     *
     * @param boolean $estrecupere
     *
     * @return UserMouchard
     */
    public function setEstrecupere($estrecupere)
    {
        $this->estrecupere = $estrecupere;

        return $this;
    }

    /**
     * Get estrecupere
     *
     * @return boolean
     */
    public function getEstrecupere()
    {
        return $this->estrecupere;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return UserMouchard
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
     * @return UserMouchard
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
     * @return UserMouchard
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
     * @return UserMouchard
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
