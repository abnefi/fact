<?php

namespace StockBundle\Controller;

use StockBundle\Entity\StockInventaireDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Stockinventairedetail controller.
 *
 * @Route("stockinventairedetail")
 */
class StockInventaireDetailController extends Controller
{
    /**
     * Lists all stockInventaireDetail entities.
     *
     * @Route("/", name="stockinventairedetail_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();
        //
        /*
         *  A revoir en fonction de société
         *
         */
        $stockInventaireDetails = $em->getRepository('StockBundle:StockInventaireDetail')->liste($soc);
        return $this->render('stockinventairedetail/index.html.twig', array(
            'stockInventaireDetails' => $stockInventaireDetails,
        ));
    }


    /**
     * Supprimer stockInventaireDetail by setEstSupprimmer.
     *
     * @Route("/supprimmer/stock/inventaire/detail/{id}", name="supprimmer_stock_Inventaire_detail")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(StockInventaireDetail $stockInventaireDetail, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $stockInventaireDetail->setEstSupprimer(true);

        $stockInventaireDetail->setUpdateBy($this->getUser()->getSlug());
        $stockInventaireDetail->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('stockinventairedetail_index');
    }

    /**
     * Finds and displays a stockInventaireDetail entity.
     *
     * @Route("/{id}", name="stockinventairedetail_show")
     * @Method("GET")
     */
    public function showAction(Request $request,StockInventaireDetail $stockInventaireDetail)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('stockinventairedetail/show.html.twig', array(
            'stockInventaireDetail' => $stockInventaireDetail,
        ));
    }
}
