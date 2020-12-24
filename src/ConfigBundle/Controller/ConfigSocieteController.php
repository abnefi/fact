<?php

namespace ConfigBundle\Controller;

use ConfigBundle\ConfigBundle;
use ConfigBundle\Entity\ConfigAbonnementSociete;
use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Entity\ConfigDevise;
use ConfigBundle\Entity\ConfigSociete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Entity\FosUser;

/**
 * Configsociete controller.
 * @Route("configsociete")
 */
class ConfigSocieteController extends Controller
{

    /**
     * save society and  agence to additional news
     *
     * @Route("/additionalNew", name="additional_new")
     * @Method({"GET", "POST"})
     */
    public function registerAdditionalNewAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $user = $this->getUser();
        $configSociete = new ConfigSociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigSocieteType', $configSociete);
        $form->handleRequest($request);

        $configAgence = new ConfigAgence();
        $devise = $this->getDoctrine()->getManager()->getRepository('ConfigBundle:ConfigDevise')->find(1);

        $Aform = $this->createForm('ConfigBundle\Form\ConfigAgence2Type', $configAgence);
        $Aform->handleRequest($request);

        $agence = $request->request->get('configbundle_configagence');

        $file = $request->files->get('configbundle_configagence');
        $ifuFileUploader = $file['societe']['ifuFile'];
        $registreFileUploader = $file['societe']['registreFile'];

        if ($Aform->isSubmitted() && $Aform->isValid()) {

            if ($ifuFileUploader){
                $ifuFile = $this->get('file_uploader')->upload('societe', $ifuFileUploader);
                $configSociete->setIfuFile($ifuFile);
            }

            if ($registreFileUploader){
                $registreFile = $this->get('file_uploader')->upload('societe', $registreFileUploader);
                $configSociete->setRegistreFile($registreFile);
            }

            $estProfessionLiberale = $agence['societe']['estProfessionLiberale'];
            $typeEntreprise = $agence['societe']['typeEntreprise'];

            $em = $this->getDoctrine()->getManager();

            $configSociete->setTypeEntreprise($agence['societe']['typeEntreprise']);
            $configSociete->setEmail($agence['societe']['email']);
            $configSociete->setAdresse($agence['societe']['adresse']);

            $banqueId = $agence['societe']['banque'];
            $banque = $em->getRepository('ConfigBundle:ConfigBanque')->find($banqueId);
            $configSociete->setBanque($banque);

            $deviseId = $agence['societe']['devise'];
            $devise = $em->getRepository('ConfigBundle:ConfigDevise')->find($deviseId);
            $configSociete->setDevise($devise);

            $telephone = $agence['societe']['telephone'];

            $search = array('+', '(', ')', '.');

            $replace = array('', '', '', '');

            $tel = str_replace($search, $replace, $telephone);
            $configSociete->setTelephone($tel);

            $configSociete->setPrenom($agence['societe']['prenom']);
            $configSociete->setNom($agence['societe']['nom']);
            $configSociete->setVille($agence['societe']['ville']);
            $configSociete->setFonctionRepresentant($agence['societe']['fonctionRepresentant']);
            $configSociete->setCapital(0);

            $idPays = $agence['societe']['pays'];
            $pays = $em->getRepository('ConfigBundle:ConfigPaysLang')->find($idPays);

            $configSociete->setPays($pays);

            if ($typeEntreprise == 'societe'){
                if ($agence['societe']['assujetiTva'] !== ""){
                    $configSociete->setAssujetiTva($agence['societe']['assujetiTva']);
                }
                $configSociete->setEstProfessionLiberale(false);
            }else{
                if ($estProfessionLiberale != ""){
                    $configSociete->setEstProfessionLiberale($estProfessionLiberale);
                }
                $configSociete->setAssujetiTva(false);
            }

            $ifu = $agence['societe']['ifu'];
            $oldIfu = $em->getRepository('ConfigBundle:ConfigSociete')->findOneBy(['ifu' => $ifu]);
            if ($oldIfu !== null){
                $error = new FormError('Ce numéro ifu existe déjà.');
                $Aform->addError($error);
                goto END;
            }

            $raisonSociale = $agence['societe']['raisonSociale'];
            $oldRaisonSociale = $em->getRepository('ConfigBundle:ConfigSociete')->findOneBy(['raisonSociale' => $raisonSociale]);
            if ($oldRaisonSociale !== null){
                $error = new FormError('La raison sociale existe déjà.');
                $Aform->addError($error);
                goto END;
            }
            $configSociete->setIfu($agence['societe']['ifu']);
            $configSociete->setRaisonSociale($agence['societe']['raisonSociale']);
            $configSociete->setRegistreCommerce($agence['societe']['registreCommerce']);
            $configSociete->setSiteWeb($agence['societe']['siteWeb']);

            $IdTypeActivite = $agence['societe']['typeActivite'];
            $typeActivite = $em->getRepository('ConfigBundle:ConfigTypeActivite')->find($IdTypeActivite);

            $configSociete->setTypeActivite($typeActivite);
            $configSociete->setRib($agence['societe']['rib']);

            $codeS = $this->get('code_generate')->genererCodeSociete();
            $configSociete->setCode($codeS);

            $configSociete->setCreated(new \DateTime());
            $configSociete->setCreatedBy($user->getSlug());
//
            //Todo: remplir la table agence
            $configAgence->setSociete($configSociete);

            $codeA = $this->get('code_generate')->genererCodeAgencePricipale($codeS);
            $configAgence->setCode($codeA);

            $configAgence->setLibelle('Agence principal');
            $configAgence->setNumeroMCF('numeroMCF');
            $configAgence->setCreatedBy($user->getSlug());
            $configAgence->setCreated(new \DateTime());
            $configAgence->setEstActif(true);
            $em->persist($configAgence);
            $em->flush();

            //Todo: ont lie l'agence à l'utilisateur
            $user = $this->getUser();
            $user->setAgence($configAgence);
            $em->persist($user);
            $em->flush();

//            $request->getSession()->getFlashBag()->add('success', 'Enregistrement réussie.');

            return $this->redirectToRoute('society_register_success');
        }
        $request->getSession()->getFlashBag()->add('echec', 'Enregistrement échoué.');

        END:
        return $this->render('guest/parts/agenceSocietyRegister.html.twig', array(
            'user' => $user,
            'societyForm' => $form->createView(),
            'agenceForm' => $Aform->createView(),
        ));

    }


    /**
     * society register succes a new configSociete entity.
     *
     * @Route("/society/register/success", name="society_register_success")
     * @Method({"GET", "POST"})
     */
    public function societyRegisterSuccess(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $agence =  $this->getUser()->getAgence();
        $agenceId = $agence->getId();
        $society = $agence->getSociete();

        $etatEssaie = $society->getDejaEssayer();
        $configAbonnementSociete = new Configabonnementsociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType', $configAbonnementSociete, ['etatEssaie'=>$etatEssaie]);
        $form->handleRequest($request);

        $configAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnement')->findBy(['estActif' => true, 'estSupprimer' => false]);

        return $this->render('guest/parts/societyRegisterSuccess.html.twig', array(
            'configAgence' => $agence,
            'id' => $agenceId,
            'configAbonnements' => $configAbonnements,
            'form' => $form->createView(),
        ));
        
    }

    /**
     * Displays a form to edit an existing configSociete entity before register.
     *
     * @Route("/{id}/edit/Society", name="society_agence_edit")
     * @Method({"GET", "POST"})
     */
    public function editSocietyAgenceAction(Request $request, ConfigAgence $configAgence )
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $agenceEditForm = $this->createForm('ConfigBundle\Form\ConfigAgence2Type', $configAgence);
        $agenceEditForm->handleRequest($request);
        $user = $this->getUser();

        $file = $request->files->get('configbundle_configagence');
        $ifuFileUploader = $file['societe']['ifuFile'];
        $registreFileUploader = $file['societe']['ifuFile'];
//        dump($ifuFileUploader, $registreFileUploader); die();

        $agence = $request->request->get('configbundle_configagence');

        $em = $this->getDoctrine()->getManager();

        if ($agenceEditForm->isSubmitted() && $agenceEditForm->isValid()) {
            $estProfessionLiberale = $agence['societe']['estProfessionLiberale'];
            $typeEntreprise = $agence['societe']['typeEntreprise'];
            if ($typeEntreprise == 'societe')
            {
                if ($agence['societe']['assujetiTva'] !== ""){
                    $configAgence->getSociete()->setAssujetiTva($agence['societe']['assujetiTva']);
                }
                $configAgence->getSociete()->setEstProfessionLiberale(false);
            }else
                {
                if ($estProfessionLiberale !== ""){
                    $configAgence->getSociete()->setEstProfessionLiberale($estProfessionLiberale);
                }
                $configAgence->getSociete()->setAssujetiTva(false);
            }

            /*mise à jour de la banque*/
            $banqueId = $agence['societe']['banque'];
            $banque = $em->getRepository('ConfigBundle:ConfigBanque')->find($banqueId);
            $configAgence->getSociete()->setBanque($banque);

            /* suppression du fichier ifu*/
            $ifuFile = $configAgence->getSociete()->getIfuFile();
            $ifuFile = 'uploads/societe/' . $ifuFile;

            if (file_exists($ifuFile)){
                @unlink($ifuFile);
            }

            /* Suppresson du fichier registerFile */
            $registreFile = $configAgence->getSociete()->getRegistreFile();
            $registreFile = 'uploads/societe/'.$registreFile;

            if( file_exists ( $registreFile)){
                @unlink( $registreFile ) ;
            }

            /*récupération du nom du fichier et enregistrement dans le dossier upload/societe*/
            if ($ifuFileUploader)
                $ifuFile = $this->get('file_uploader')->upload('societe', $ifuFileUploader);
            if ($registreFileUploader)
                $registreFile = $this->get('file_uploader')->upload('societe', $registreFileUploader);

            /*enregistrement de l'url dans la base de donné*/
            $configAgence->getSociete()->setIfuFile($ifuFile);
            $configAgence->getSociete()->setRegistreFile($registreFile);

            $configAgence->getSociete()->setUpdateBy($this->getUser()->getSlug());
            $configAgence->getSociete()->setUpdateAt(new \DateTime());

            $configAgence->setUpdateBy($this->getUser()->getSlug());
            $configAgence->setUpdateAt(new \DateTime());

            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Modification réussie.');
            return $this->redirectToRoute('society_register_success', array('id' => $configAgence->getId()));
        }

        return $this->render('configsociete/edit2.html.twig', array(
            'configAgence' => $configAgence,
            'user' => $user,
            'agenceForm' => $agenceEditForm->createView(),
        ));
    }

    /**
     * Finds and displays a configSociete entity.
     *
     * @Route("/", name="configsociete_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CLT_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        return $this->render('configsociete/show.html.twig', array(
            'configSociete' => $this->getUser()->getAgence()->getSociete(),
        ));
    }

    /**
     * Displays a form to edit an existing configSociete entity.
     *
     * @Route("/{id}/edit/logo", name="configsociete_edit_logo")
     * @Method({"GET", "POST"})
     */
    public function editLogoAction(Request $request, ConfigSociete $configSociete)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CLT_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $fichierAUploader = $request->files->get("logo_societe");

        $logo = $this->get('file_uploader')->upload('societe', $fichierAUploader);
//        dump($logo);die();
        $configSociete->setUpdateBy($this->getUser()->getSlug());
        $configSociete->setUpdateAt(new \DateTime());

        $configSociete->setLogo($logo);

        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('configsociete_show', array('id' => $configSociete->getId()));

    }

    /**
     * Displays a form to edit an existing configSociete entity.
     *
     * @Route("/{id}/edit", name="configsociete_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigSociete $configSociete)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CLT_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $editForm = $this->createForm('ConfigBundle\Form\ConfigSocieteType', $configSociete);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $societe = $request->request->get('configbundle_configsociete');

            $estProfessionLiberale = $societe['estProfessionLiberale'];
            $typeEntreprise = $societe['typeEntreprise'];
            if ($typeEntreprise == 'societe') {
                if ($societe['assujetiTva'] !== ""){
                    $configSociete->setAssujetiTva($societe['assujetiTva']);
                }
                $configSociete->setEstProfessionLiberale(false);
            }else{
                if ($estProfessionLiberale !== ""){
                    $configSociete->setEstProfessionLiberale($estProfessionLiberale);
                }
                $configSociete->setAssujetiTva(false);
            }

//            dump($configSociete);die();
            $telephone = $societe['telephone'];
            $search = array('+', '(', ')', '.');
            $replace = array('', '', '', '');
            $tel = str_replace($search, $replace, $telephone);
            $configSociete->setTelephone($tel);

            $configSociete->setUpdateBy($this->getUser()->getSlug());
            $configSociete->setUpdateAt(new \DateTime());

            $em->flush();

            $request->getSession()->getFlashBag()->add('succes','Modification effectuée avec succès.');
            return $this->redirectToRoute('configsociete_show', array('id' => $configSociete->getId()));
        }
        return $this->render('configsociete/edit.html.twig', array(
            'configSociete' => $configSociete,
            'form' => $editForm->createView(),
        ));
    }

}
