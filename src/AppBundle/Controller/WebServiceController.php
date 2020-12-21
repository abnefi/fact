<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 25/03/2020
 * Time: 10:18
 */

namespace AppBundle\Controller;

use ConfigBundle\Entity\ConfigEtat;
use OperationsClientBundle\Entity\ClientFacture;
use OperationsClientBundle\Entity\ClientFactureAvoir;
use OperationsClientBundle\Entity\ClientFactureReponse;
use OperationsClientBundle\Entity\ClientFactureVente;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Webservice controller.
 *
 * @Route("webservice")
 */
class WebServiceController extends Controller
{
    /**
     * @Route("/send/data/declaration")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function sendDataDeclarationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), false);
            foreach ($data as $datum) {
                $facture = $em->getRepository(ClientFacture::class)->find($datum->idOnline);
                if ($facture) {
                    $facture->setIdLocal($datum->facture);
                }
            }
            $em->flush();
            return new Response('Mise à jour effectué avec succès');
        }

        $etatEnAttente = $em->getRepository(ConfigEtat::class)->findOneBy(['code' => 'EA']);
        $facturesADeclarer = $em->getRepository(ClientFacture::class)
            ->findBy(['etatDeclaration' => $etatEnAttente,'estSupprimer'=>0, 'idLocal' => null]);

        return $this->json($facturesADeclarer, 200, [], [
            'groups' => ['fact_api'],
        ]);
    }



    /**
     * @Route("/receive/data/declaration/encours")
     * @Method({"GET"})
     */
    public function receiveDataDeclarationEncoursAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();

        $referencesDeclarationEncours = json_decode($request->getContent());
        $nbSucces = 0;
        $nbReferencesIntrouvables = 0;
        if ($referencesDeclarationEncours != null) {
            foreach ($referencesDeclarationEncours as $reference) {
                $facture = $em->getRepository('OperationsClientBundle:ClientFacture')
                    ->findOneBy(['reference' => $reference,'estSupprimer'=>0]);
                if ($facture) {
                    $etatEnCours = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'EC','estSupprimer'=>0]);
                    $facture->setEtatDeclaration($etatEnCours);

                    $facture->setCreated(new \DateTime());
                    $facture->setCreatedBy('service');

                    $em->persist($facture);
                    $nbSucces++;
                }
                else{
                    $nbReferencesIntrouvables++;
                }

            }
            $em->flush();

            $msg = $nbSucces . " factures ont été mis à jour avec succès.";
            if ($nbReferencesIntrouvables > 0) {
                $msg .= $nbReferencesIntrouvables . " factures n'ont pas été mis à jour car la référence est introuvable.";
            }
            $retour = ['code' => 200, 'message' => $msg];
            return new JsonResponse($retour);
        } else {
            $retour = ['code' => 404, 'message' => "Aucune réponse de facture n'a été envoyée"];
            return new JsonResponse($retour);
        }

        return $this->json($facturesEnCoursDeclaration, 200, [], [
            'groups' => ['fact_encours_api'],
        ]);
    }

    /**
     * @Route("/receive/data/reponse")
     * @Method({"POST"})
     */
    public function receiveDataReponse(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $reponsesDeclaration = json_decode($request->getContent());
        $nbSucces = 0;
        $nbReferencesIntrouvables = 0;
        if ($reponsesDeclaration != null) {
            foreach ($reponsesDeclaration as $reponse) {
                $facture = $em->getRepository('OperationsClientBundle:ClientFacture')
                    ->findOneBy(['reference' => $reponse->reference,'estSupprimer'=>0]);
                if ($facture) {
                    $factureReponse = new ClientFactureReponse();
                    $factureReponse->setReferenceFacture($reponse->reference);
                    $factureReponse->setCompteurTypeFacture($reponse->compteurTypeFacture);
                    $factureReponse->setCompteurTotal($reponse->compteurTotal);
                    $factureReponse->setDateHeure($reponse->dateHeure);
                    $factureReponse->setSig($reponse->sig);
                    $factureReponse->setCodeQR($reponse->codeQR);

                    $factureReponse->setCreated(new \DateTime());
                    $factureReponse->setCreatedBy('service');
                    $factureReponse->setEstSupprimer(0);

                    $em->persist($factureReponse);

                    $etatTermine = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'TR','estSupprimer'=>0]);
                    $facture->setEtatDeclaration($etatTermine);
                    $facture->setReponse($factureReponse);

                    $facture->setCreated(new \DateTime());
                    $facture->setCreatedBy('service');

                    $em->persist($facture);
                    $nbSucces++;
                } else {
                    $nbReferencesIntrouvables++;
                }
            }

            $em->flush();

            $msg = $nbSucces . " réponses ont été insérées avec succès.";
            if ($nbReferencesIntrouvables > 0) {
                $msg .= $nbReferencesIntrouvables . " réponses n'ont pas été insérées car la référence est introuvable.";
            }
            $retour = ['code' => 200, 'message' => $msg];
            return new JsonResponse($retour);
        } else {
            $retour = ['code' => 404, 'message' => "Aucune réponse de facture n'a été envoyée"];
            return new JsonResponse($retour);
        }


    }
}
