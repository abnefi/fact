<?php


namespace AppBundle\Service;

use ConfigBundle\Entity\ConfigTypeFacture;
use Symfony\Component\DependencyInjection\Container;

class CodeAleatoire
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

    public function verifieUniqueReference($reposite,$code)
    {
        $confg_type = $this->em->getRepository($reposite)->findBy(['reference'=>$code]);

        if ($confg_type != null && $confg_type != '' && $confg_type != [] && count($confg_type) > 0)
        {
            $etat=false;
        }else{
            $etat=true;
        }

        return $etat;
    }

    public function genererCodeSociete()
    {
        $num = $this->em->getRepository('ConfigBundle:ConfigSociete')->taille() + 1;
        $Aleatoire=random_int(1,99);
        $numOrdre = str_pad($num, 3, "0", STR_PAD_LEFT);

        $code = 'ST'.$numOrdre.$Aleatoire;
        $confg_type = $this->em->getRepository('ConfigBundle:ConfigSociete')->findBy(['code'=>$code]);

        if (($confg_type != null && $confg_type != '' && $confg_type != [] && count($confg_type) > 0)) {
            $this->genererCodeSociete();
        }

        return $code;
    }

    public function genererCodeAgencePricipale($codeSociete)
    {
        $num = $this->em->getRepository('ConfigBundle:ConfigAgence')->taille() + 1;
        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $code = $codeSociete.'AG'.$numOrdre1.$num.$numOrdre2;

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigAgence')->findBy(['code'=>$code]);

        if (($confg_type != null && $confg_type != '' && $confg_type != [] && count($confg_type) > 0)) {
            $this->genererCodeAgencePricipale();
        }

        return $code;
    }

    public function genererCodeAgence($societe)
    {
        $num = $this->em->getRepository('ConfigBundle:ConfigAgence')->tailles($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();

        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getCodeAgence().$numOrdre1.$num.$numOrdre2;


        $verifie_code = $this->em->getRepository('ConfigBundle:ConfigAgence')->findBy(['code'=>$code]);


        if (($verifie_code != null && $verifie_code != '' && $verifie_code != [] && count($verifie_code) > 0)) {
            $this->genererCodeAgence($societe);
        }

        return $code;
    }


    public function genererCodeFournisseur($societe)
    {
        $num = $this->em->getRepository('TiersBundle:TiersFournisseur')->taille($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();
        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getCodeAgence().$numOrdre1.$num.$numOrdre2;

        $verifie_code = $this->em->getRepository('TiersBundle:TiersFournisseur')->findBy(['code'=>$code]);

        if (($verifie_code != null && $verifie_code != '' && $verifie_code != [] && count($verifie_code) > 0)) {
            $this->genererCodeFournisseur($societe);
        }

        return $code;
    }

    public function genererCodeClient($societe)
    {
        $num = $this->em->getRepository('TiersBundle:TiersClient')->taille($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();
        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getCodeClient().$numOrdre1.$num.$numOrdre2;

        $verifie_code = $this->em->getRepository('TiersBundle:TiersClient')->findBy(['code'=>$code]);

        if (($verifie_code != null && $verifie_code != '' && $verifie_code != [] && count($verifie_code) > 0)) {
            $this->genererCodeClient($societe);
        }
        return $code;
    }

    public function genererReferenceArticle($societe)
    {
        $num = $this->em->getRepository('StockBundle:StockArticle')->taille($societe) +1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();
        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getReferenceArticle().$numOrdre1.$num.$numOrdre2;

        if (!$this->verifieUniqueReference('StockBundle:StockArticle',$code)) {
           $this->genererReferenceArticle($societe);
       }

        return $code;
    }

    public function genererReferenceService($societe)
    {
        $num = $this->em->getRepository('StockBundle:StockService')->taille($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();
        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getReferenceService().$numOrdre1.$num.$numOrdre2;

        if (!$this->verifieUniqueReference('StockBundle:StockService',$code)) {
            $this->genererReferenceService($societe);
        }
        return $code;
    }

    public function genererReferenceApprovisionnement($societe)
    {
        $num = $this->em->getRepository('StockBundle:StockApprovisionnement')->taille($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();
        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getReferenceApprovisionnement().$numOrdre1.$num.$numOrdre2;

        if (!$this->verifieUniqueReference('StockBundle:StockApprovisionnement',$code)) {
            $this->genererReferenceApprovisionnement($societe);
        }

        return $code;
    }

    public function genererReferenceFacture(ConfigTypeFacture $configTypeFacture,$societe)
    {
        $num = $this->em->getRepository('OperationsClientBundle:ClientFacture')->taille($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $code = $confg_type->getSociete()->getCode().$configTypeFacture->getCode().$numOrdre1.$num.$numOrdre2;

        if (!$this->verifieUniqueReference('OperationsClientBundle:ClientFacture',$code)) {
            $this->genererReferenceArticle($societe);
        }

        return $code;
    }

    public function genererReferenceInventaire($societe)
    {
        $num = $this->em->getRepository('StockBundle:StockInventaire')->taille($societe) + 1;

        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $this->em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$societe,'estSupprimer'=>0,'estGenere'=>1]);
        $typeG_Societe=$confg_type->getTypeGeneration();
        $code = $confg_type->getSociete()->getCode().$typeG_Societe->getReferenceApprovisionnement().$numOrdre1.$num.$numOrdre2;

        $verifie_code = $this->em->getRepository('StockBundle:StockInventaire')->findBy(['referenceInventaire'=>$code]);

        if (($verifie_code != null && $verifie_code != '' && $verifie_code != [] && count($verifie_code) > 0)) {
            $this->genererReferenceArticle($societe);
        }


        return $code;
    }

}