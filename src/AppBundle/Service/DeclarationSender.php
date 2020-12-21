<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 24/03/2020
 * Time: 13:03
 */

namespace AppBundle\Service;

use DeclarationBundle\DeclarationBundle;
use DeclarationBundle\Entity\DeclarationFacture;
use OperationsClientBundle\Entity\ClientFactureAvoir;
use OperationsClientBundle\Entity\ClientFactureVente;
use Symfony\Component\DependencyInjection\Container;
use UserBundle\Entity\FosUser;


class DeclarationSender
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

    public function sendDataFactures(FosUser $user)
    {
//        $conn = $this->container->get("doctrine.dbal.declaration_mcf_connection");
        $emDeclaration = $this->container->get("doctrine")->getManager("declaration_mcf");
        $etatEnAttente = $this->em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'EA']);
        $facturesADeclarer = $this->em->getRepository('OperationsClientBundle:ClientFacture')
            ->findBy(['etatDeclaration' => $etatEnAttente]);
        foreach ($facturesADeclarer as $facture) {
            $declaration = new DeclarationFacture();
            $declaration->setTypeFacture($facture->getTypeFacture()->getCode());
            $declaration->setNomClient($facture->getClient()->getNom());
            $declaration->setIfuClient($facture->getClient()->getIfu());
            if ($facture->getTypeFacture()->getAvoir() == true) {
                $declaration->setReferenceFactureOrigine($facture->getReferenceFactureOrigine());
            }
            $declaration->setNumeroFacture($facture->getReference());
            $declaration->setNumeroMcf($user->getAgence()->getNumeroMCF());
            $declaration->setSocieteIfu($user->getAgence()->getSociete()->getIfu());
            $declaration->setSocieteNom($user->getAgence()->getSociete()->getRaisonSociale());
            $declaration->setTaxeTva($facture->getTauxTVA());
            $declaration->setTaxeAib($facture->getTauxAIB());
            $declaration->setVersion($this->container->getParameter('version_mcf'));

            $declaration->setCreated(new \DateTime());
            $declaration->setCreatedBy($this->getUser()->getSlug());

            $emDeclaration->persist($declaration);

            $etatEnCours = $this->em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'EC']);
            $facture->setEtatDeclaration($etatEnCours);

            $facture->setCreated(new \DateTime());
            $facture->setCreatedBy($this->getUser()->getSlug());
            $facture->setEstSupprimer(0);

            $this->em->persist($facture);
        }

//        return $code;
    }

}