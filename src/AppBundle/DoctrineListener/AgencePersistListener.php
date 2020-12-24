<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 06/03/2020
 * Time: 18:06
 */

namespace AppBundle\DoctrineListener;

use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Entity\ConfigSociete;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use StockBundle\Entity\StockApprovisionnementDetail;
use Symfony\Component\HttpFoundation\Session\Session;

class AgencePersistListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $session = new Session();
        $soc = $session->get('id_societe');

        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof ConfigAgence) {
            return;
        }

        $num = $entityManager->getRepository('ConfigBundle:ConfigAgence')->tailles($soc) + 1;
        a:
        $Aleatoire1=random_int(0,99);
        $Aleatoire2=random_int(0,99);

        $numOrdre1 = str_pad($Aleatoire1, 2, "0", STR_PAD_LEFT);
        $numOrdre2 = str_pad($Aleatoire2, 2, "0", STR_PAD_LEFT);

        $confg_type = $entityManager->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findOneBy(['societe'=>$soc,'estSupprimer'=>0,'estGenere'=>1]);

        if($confg_type ==null || $confg_type ==[])
        {
            $totalSociete = $entityManager->getRepository(ConfigSociete::class)->taille()+1;
            $totalAgence = $entityManager->getRepository(ConfigAgence::class)->tailles() + 1;
            $code = 'SOT' . $totalSociete . 'AGPR' . $totalAgence;
        } else
            {
            $typeG_Societe=$confg_type->getTypeGeneration();
            $code = $confg_type->getSociete()->getCode().$typeG_Societe->getCodeAgence().$numOrdre1.$num.$numOrdre2;
        }

        $verifie_code = $entityManager->getRepository('ConfigBundle:ConfigAgence')->findBy(['code'=>$code]);

        if ($verifie_code != null && $verifie_code != '' && $verifie_code != [] && count($verifie_code) > 0) {
            goto a;
        }

        /* $agences = $entityManager->getRepository('ConfigBundle:ConfigAgence')->findAll();
         $num = count($agences) + 1;
         $numOrdre = str_pad($num, 2, "0", STR_PAD_LEFT);
         $code = 'AG' . $numOrdre;*/

        $entity->setCode($code);

    }
}