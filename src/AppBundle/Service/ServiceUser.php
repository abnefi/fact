<?php


namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container as Container;

class ServiceUser
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;

    public function __construct(\Doctrine\ORM\EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getUserSociete($userPublicId)
    {
//        $userPublicId = $this->getUser()->getuserPublicId();
        $userSociete = $this->em->getRepository('UserBundle:UserSociete')
            ->findOneBy(['userPublicId' => $userPublicId]);
        return $userSociete;
    }

}