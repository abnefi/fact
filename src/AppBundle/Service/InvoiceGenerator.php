<?php
/**
 * Created by PhpStorm.
 * User: gnacadja
 * Date: 12/11/2020
 * Time: 12:52
 */

namespace AppBundle\Service;

use DateTime;
use OperationsClientBundle\Entity\ClientFacture;
use stdClass;
use Symfony\Component\DependencyInjection\Container as Container;
use Endroid\QrCode\QrCode;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use UserBundle\Entity\FosUser;

class InvoiceGenerator
{

    /**
     * @var ClientOperations
     */
    private $clientOperations;

    public function __construct(ClientOperations $clientOperations)
    {
        $this->clientOperations = $clientOperations;
    }

    /**
     * @param FosUser            $user
     * @param ClientFactureVente $clientFactureVente
     * @param bool               $definitive
     *
     * @param string             $libelle
     *
     * @param bool               $json
     * @param string             $dir
     *
     * @return Pdf|stdClass
     */
    public function generate(FosUser $user, ClientFacture $clientFactureVente, $definitive = false, $libelle = 'FACTURE', $json = false, $dir = '') {
        $urlLogo = 'frontend/img/ogi-logo.png';
        $societe = $user->getAgence()->getSociete();
        $declarationResponse = $clientFactureVente->getReponse();

        $totalHT = $this->clientOperations->calculerMontantFactureHT($clientFactureVente);
        $totalTVA = $this->clientOperations->calculerMontantTVAFacture($clientFactureVente);
        $totalAIB = $this->clientOperations->calculerMontantAIBFacture($clientFactureVente);
        $totalTaxeSpecifique = $this->clientOperations->calculerTotalTaxeSpecifiqueFacture($clientFactureVente);
        $totalTTC = $this->clientOperations->calculerMontantFactureTTC($clientFactureVente, $totalHT, $totalTVA, $totalAIB, $totalTaxeSpecifique);
        $totalAPayer = $this->clientOperations->calculerMontantNetAPayer($clientFactureVente, $totalTTC, $totalAIB);
        $taxeSejour = $this->clientOperations->calculerTaxeSejour($clientFactureVente);

        $summer = [
            'Montant total HT' => $totalHT,
            'Montant total TVA' => $totalTVA,
            'Montant total AIB' => $totalAIB,
            'Total Taxe de Séjour' => $taxeSejour,
            'Total Taxe Specifique' => $totalTaxeSpecifique,
            'Montant total TTC' => $totalTTC
        ];

        if(!is_null($societe->getLogo())){
            /*$request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() .*/
            $urlLogo = 'uploads/societe/' . $societe->getLogo();
        }


        $client = $clientFactureVente->getClient();

        if ($client->getPays() !== $societe->getPays()) {
            $libelle .= ' D\'EXPORTATION';
        }

        $destinataire = [
            'nom' => $client->getNom(),
            'ifu' => $client->getIfu(),
        ];

        $sendTo = [
            'nom' => $client->getNom(),
            'ifu' => '',
        ];

        $facture = [
            'date' => $clientFactureVente->getDateFacture()->format('d-m-Y'),
            'ref' => $clientFactureVente->getReference() . '-' . strtoupper($user->getAgence()->getCode())
        ];

        if ($definitive) {
            //Génération du code QR
            $qrCode = new QrCode($declarationResponse->getCodeQR());
            $qrCode->setSize(100);
            $qrCode->setErrorCorrection('medium');
            $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
            $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
            $facture['qr_code'] = $qrCode->getDataUri();
        }


        $entreprise = [
            'logo'           => $urlLogo,
            'raison_sociale' => $societe->getRaisonSociale(),
            'adresse'        => $societe->getAdresse(),
            'contact'        => $societe->getTelephone(),
            'email'          => $societe->getEmail(),
            'site'           => $societe->getSiteWeb(),
            'ifu'            => $societe->getIfu(),
            'rccm'           => $societe->getRegistreCommerce(),
            'compte'         => $societe->getRib(),
        ];

        $produits = [];
        foreach ($clientFactureVente->getDetails() as $detail) {
            $produits[] = [
                'designation'   => $detail->getProduit()->getDesignation(),
                'taxe'          => $detail->getProduit()->getTaxeGroupe()->getCode(),
                'cout_unitaire' => $detail->getPrixVenteUnitaire(),
                'qte'           => $detail->getQuantite(),
                'net'           => $this->clientOperations->calculerProduitTTC($detail)
            ];
        }

        $pdf = new Pdf('P', 'mm', 'A4', $entreprise, $produits, $facture, $libelle);

        $pdf->AddFont('helveticai', '', 'helveticai.php');
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->AddPage();
        $pdf->setAlpha(0.05);
        //$pdf->Image('frontend/img/ogi-logo.png', 60, 100, 100, 100);
        $pdf->setAlpha(1);

        $pdf->setDestination($destinataire, $sendTo);
        $pdf->FancyTable();
        $pdf->SummeryTable($summer, $totalAPayer, 'XOF');

        if ($definitive) {
            $declarationInfo = [
                'MECeF NIM' => $clientFactureVente->getAgence()->getNumeroMCF(),
                'MECeF Compteurs' => $declarationResponse->getCompteurTypeFacture()
                    . '/' . $declarationResponse->getCompteurTotal()
                    . ' ' . $clientFactureVente->getTypeFacture()->getCode(),
                'MECeF Heure' => (new DateTime($declarationResponse->getDateHeure()))->format('d/m/Y H:i:s')
            ];

            $pdf->DeclarationSection($declarationInfo);
        }

        if ($json) {
            $today = new DateTime();
            $info = new stdClass();
            $info->fileName = $clientFactureVente->getReference() . '_' . $today->format('d_m_Y_H_i_s') . '.pdf';
            $filesystem = new Filesystem();
            $info->filePath = $dir . "tmp/" . $info->fileName;

            try {
                $filesystem->mkdir('uploads/tmp/', 0700);
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at " . $exception->getPath();
            }

            $pdf->Output('F', $info->filePath);

            return $info;
        }

        return $pdf;
    }
}