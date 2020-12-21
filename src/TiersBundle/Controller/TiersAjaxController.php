<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 12/03/2020
 * Time: 16:08
 */

namespace TiersBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TiersBundle\Entity\TiersClient;
use UserBundle\Entity\MouchardFichier;
use Symfony\Component\HttpFoundation\Session\Session;


class TiersAjaxController extends Controller
{

    /**
     *
     * @Route("/form/shortcut/new/client", options={"expose"=true}, name="form_shortcut_new_client")
     * @Method({"GET", "POST"})
     */
    public function formShortcutNewClientAction(Request $request)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $tiersClient = new Tiersclient();
        $soc = $this->getUser()->getAgence()->getSociete();
        $code = $this->get('code_generate')->genererCodeClient($soc->getId());
        $tiersClient->setCode($code);
        $form = $this->createForm('TiersBundle\Form\TiersClientType', $tiersClient);
        if ($request->isXmlHttpRequest()) {

        }

        return $this->render('tiersclient/form_shortcut.html.twig', [
            'tiersClient' => $tiersClient,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @Rest\Route("/form/modal/new/client", name="form_modal_new_client")
     *
     * @return Response
     */
    public function modalNewClientAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        // Pour le modal d'un nouveau client
        $em = $this->getDoctrine()->getManager();
        $tiersClient = new Tiersclient();
        $soc = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $soc, 'estSupprimer' => 0, 'estGenere' => 1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $code = $this->get('code_generate')->genererCodeClient($soc->getId());
            $tiersClient->setCode($code);
        } else {
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');
        }

        $formClient = $this->createForm('TiersBundle\Form\TiersClientType', $tiersClient);
        $formClient->handleRequest($request);

        if ($formClient->isSubmitted() && $formClient->isValid()) {
            $tiersClient->setSociete($soc);
            $tiersClient->setCreated(new \DateTime());
            $tiersClient->setCreatedBy($this->getUser()->getSlug());
            $tiersClient->setEstSupprimer(0);

            $em->persist($tiersClient);
            $em->flush();

            $clients = $em->getRepository('TiersBundle:TiersClient')->findBy(['estSupprimer' => 0, 'societe' => $soc]);
            $em->persist($tiersClient);
            $em->flush();

            $clients = $em->getRepository('TiersBundle:TiersClient')->findAll();
            $arrayClients = [];
            $response = [];
            foreach ($clients as $client) {
                $ligne = [];
                $ligne['id'] = $client->getId();
                $ligne['nom'] = $client->getNom();
                $ligne['tva'] = $client->getPays()->getTauxTva();
                $ligne['moral'] = $client->getEstPersonneMoral();
                $arrayClients[] = $ligne;
            }

            $response['arrayClients'] = $arrayClients;
            $response['idNewClient'] = $client->getId();

            return new JsonResponse($response);
        }
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'body'  => $this->renderView('tiersclient/new_modal_form.html.twig', [
                    'formNewClient' => $formClient->createView(),
                ]),
                'error' => true
            ]);
        }

        return $this->render('tiersclient/new_modal_form.html.twig', [
            'formNewClient' => $formClient->createView()
        ]);
    }
}