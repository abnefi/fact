<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 05/03/2020
 * Time: 18:34
 */

namespace AppBundle\Service;

use OperationsClientBundle\Entity\ClientFacture;
use OperationsClientBundle\Entity\ClientFactureVente;
use Symfony\Component\DependencyInjection\Container;

class EcritureComptable
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

    public function passerEcritureVente(ClientFactureVente $facture, $montantTTC, $urlMoteurComptable)
    {
        $param["libelleoperation"] = 'facturation vente';
        $param["codesociete"] = "FINAN";
        $param["dateoperation"] = $facture->getDateFacture()->format("Y-m-d H:i:s");
        $param["datesaisie"] = $facture->getDateFacture()->format("Y-m-d H:i:s");
        $param["datevaleur"] = $facture->getDateFacture()->format("Y-m-d H:i:s");
        $param["valeur"] = $montantTTC;
        $param["id"] = $facture->getId();
        $param["idopextourne"] = 0;
        $param["estopextourne"] = -1;
        $param["formules"] = [];
        $param["codeapplication"] = 'FACT';
        $param["valeurTiers"] = 'CLT';
//                die(dump($param));
        $url = $urlMoteurComptable . "passer/ecriture";

        $json = json_encode($param);
        $data = array();
        $data["operation"] = $json;
        $options = array(
            'timeout' => 100,
            'connect_timeout' => 100,
        );
        $resultat = [];
//        dump($data);die();

        try {
            $response = \Requests::post($url, $options, $data);
            dump($response);
            die();
            $body = $response->body;
            $body = json_decode($body);
            $code = $body->code;
            $message = $body->message;

            if ($code == 200 || $code == 202) {
                $facture->setEcriturePassee(true);
                $resultat['ecriturePassee'] = true;
            } else {
                $facture->setEcriturePassee(false);
//                $session->set('messageError', 'Mais il se pourrait que l\'écriture soit mal passée') ;
                $resultat['ecriturePassee'] = false;
            }
//            $approvisionnement->setMessageEcriturePasser($message);
            $this->em->persist($facture);
            $this->em->flush();

        } catch (\Exception $exception) {
            $facture->setEcriturePassee(false);
//            $facture->setMessageEcriturePasser($exception->getMessage());
            dump($exception);
            die();
            $this->em->persist($facture);
            $this->em->flush();
//            $session->set('messageError', 'Mais il se pourrait que l\'écriture soit mal passée') ;
            $resultat['ecriturePassee'] = false;
        }
        return $resultat;
    }
}