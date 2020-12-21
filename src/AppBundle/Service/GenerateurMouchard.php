<?php
/**
 * Created by IntelliJ IDEA.
 * User: gbegan
 * Date: 11/03/2019
 * Time: 17:23
 */

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container as Container;
use UserBundle\Entity\UserMouchard;

class GenerateurMouchard
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

    public function genererUserMouchard($entityName, $userPublicId, $action, $path, $codeApp, $entityId)
    {
        $mouchard = new UserMouchard();
        $mouchard->setDateAction(new \DateTime());
        $mouchard->setEntityName($entityName);
        $mouchard->setCreated(new \DateTime());
//        $mouchard->setUsername($this->getUser()->getuserPublicId());
        $mouchard->setUsername($userPublicId);
        $mouchard->setAction($action);
        $mouchard->setPath($path);
//        $mouchard->setCodeApp($this->getParameter('app_code'));
        $mouchard->setCodeApp($codeApp);
        $mouchard->setEstrecupere(false);
        $mouchard->setEntityId($entityId);

        $mouchard->setCreated(new \DateTime());
        $mouchard->setCreatedBy($this->getUser()->getSlug());
        $mouchard->setEstSupprimer(0);

        $this->em->persist($mouchard);
        $this->em->flush();
//        dump($mouchard);die();
    }
}