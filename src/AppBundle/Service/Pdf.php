<?php

namespace AppBundle\Service;

use NumberFormatter;

class Pdf extends Fpdf
{

    protected $fact;
    protected $regle;
    protected $entreprise;
    protected $ref;
    protected $detail;
    protected $facture;
    protected $libelle;
    private $startCodeParaph;
    var $extgstates = [];

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4', $ent, $detail, $facture, $libelle = 'FACTURE')
    {
        parent::__construct($orientation, $unit, $size);
        $this->entreprise = $ent;
        $this->ref = $facture['ref'];
        $this->detail = $detail;
        $this->facture = $facture;
        $this->libelle = $libelle;
    }

    // En-tête
    function Header()
    {
        $this->SetFont('', 'B', 18);
//        $this->AddFont('Helveticai', '', 'helveticai.php');
//        $this->AddFont('Helvetica', '', 'helvetica.php');
        $this->SetY(0);
        $this->SetX(2);
        $this->SetDrawColor(7, 14, 255);
        $this->SetFillColor(7, 14, 255);
        $this->Cell(206, 6, '', 1, 0, 'L', true);


        $this->SetX(10);
        $this->SetY(18);

        $this->Image($this->entreprise['logo'], 170, 10, 30);
        $this->Cell(0, 5, UTF8_decode($this->libelle), 0, 0, 'L');
        $this->Ln(25);

    }

    public function setDestination($destinataire, $sendTo)
    {
        $this->SetFont('', 'B', 16);
        $this->Cell(35, 5, UTF8_decode(strtoupper($this->entreprise['raison_sociale'])), 0, 0, 'L');
        $this->SetFont('', 'I', 12);
        $this->Cell(0, 5, UTF8_decode('Cotonou, le ' . (new \DateTime())->format('d/m/Y')), 0, 1, 'R');

        $this->SetFont('Helvetica', 'IB', 10);
        $this->Cell(0, 4, UTF8_decode($this->entreprise['adresse']), 0, 1, 'L');

        $this->Cell(35, 4, UTF8_decode($this->entreprise['contact']), 0, 0, 'L');
        $this->Cell(0, 5, UTF8_decode($this->ref), 0, 1, 'R');

        if ($this->entreprise['email'] and $this->entreprise['site']) {
            $this->Cell(0, 4, UTF8_decode($this->entreprise['email'] . ' - ' . $this->entreprise['site']), 0, 0, 'L');
        } else {
            if ($this->entreprise['email']) {
                $this->Cell(0, 4, UTF8_decode($this->entreprise['email']), 0, 0, 'L');
            }
            if ($this->entreprise['site']) {
                $this->Cell(0, 4, UTF8_decode($this->entreprise['site']), 0, 0, 'L');
            }
        }
        $this->Ln(15);


        $this->SetFont('Helvetica', 'B', 12);
        $this->SetDrawColor(200);
        $this->Cell(90, 6, UTF8_decode('Destinataire'), 'B', 0, 'L');
        $this->Cell(10);
        $this->Cell(88, 6, UTF8_decode('Envoyer à'), 'B', 0, 'L');
        $this->Ln(8);
        $this->SetFont('', '', 8);
        foreach ($destinataire as $key => $value) {
            $this->Cell(90, 4, UTF8_decode($value), '', 0, 'L');
            $this->Cell(10);
            $this->Cell(90, 4, UTF8_decode($sendTo[$key]), '', 1, 'L');
        }

        $this->Ln(5);
    }


    function FancyTable()
    {
        $header = ['DESIGNATION', 'TAXE', 'QUANTITE', 'PRIX UNITAIRE', 'COUT TTC'];
        $this->SetX(12);

        $this->SetFont('Helvetica', 'B', 10);
        $this->SetDrawColor(180);
        $this->SetFillColor(7, 14, 255);
        $this->SetTextColor(255, 255, 255);
        $w = [84, 20, 20, 30, 30];
        $align = ['L', 'C', 'C', 'R', 'R'];

        for ($i = 0, $iMax = count($header); $i < $iMax; $i++) {
            $this->Cell($w[$i], 7, UTF8_decode($header[$i]), 1, 0, $align[$i], true);
        }

        $this->Ln();
        $this->SetFont('Helvetica', '', 9);
        $this->SetFillColor(230);
        $this->SetTextColor(0);
        $fill = false;
        foreach ($this->detail as $value) {
            $prix_net = $value['cout_unitaire'];
            $i++;
            if (strlen($value['designation']) > 60) {
                $produit = substr($value['designation'], 0, 60) . '...';
            } else {
                $produit = $value['designation'];
            }
            $qte = strlen($value['qte']) == 1 ? '0' . $value['qte'] : $value['qte'];
            $this->SetX(12);
            $this->Cell($w[0], 6, UTF8_decode($produit), '1', 0, 'J', $fill);
            $this->Cell($w[1], 6, UTF8_decode($value['taxe']), '1', 0, 'C', $fill);
            $this->Cell($w[2], 6, $qte, '1', 0, 'C', $fill);
            $this->Cell($w[3], 6, number_format($prix_net, 0, ' ', ' '), '1', 0, 'R', $fill);
            $this->Cell($w[4], 6, number_format($value['net'], 0, ' ', ' '), '1', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Ln(3);
    }


    function SummeryTable($data, $net, $device) {
        $this->startCodeParaph = $this->GetY();
        $this->SetFont('Helvetica', '', 10);
        $this->SetDrawColor(200);

        foreach ($data as $key => $value) {
            if (!$value) continue;

            $this->SetX(125);
            $this->Cell(30, 7, UTF8_decode($key), '', 0, 'R');
            $this->Cell(2);
            $border = $key === 'Montant total TTC' ? '' : 'B';
            $this->Cell(39, 7, UTF8_decode(number_format($value, 0, ' ', ' ')), $border, (bool)$border, 'R');
        }
        $this->Ln(3);

        $this->SetFont('Helvetica', 'B', 12);
        $this->SetDrawColor(2);
        $this->SetX(125);
        $this->Cell(71, 6, '', 'B', 1, 'R');

        $this->SetX(125);
        $this->Cell(30, 9, UTF8_decode('Net à payer'), '', 0, 'R');
        $this->Cell(2);
        $this->Cell(39, 9, UTF8_decode(number_format($net, 0, ' ', ' '). ' ' . $device), 'B', 1, 'R');

        $this->Ln(15);
    }

    function DeclarationSection($data) {
        $this->SetY($this->startCodeParaph-1);
        $this->SetDrawColor(200);
        $this->SetFont('Helvetica', '', 10);

        $showCodeQR = true;
        foreach ($data as $key => $value) {
            if ($showCodeQR) {
                $showCodeQR = false;

                $img = explode(',',$this->facture['qr_code'],2);
                $codeQR = 'data://text/plain;base64,'. $img[1];
                $this->Image($codeQR, 85, $this->GetY(), 30, 0, 'png');
                $this->Ln(4);
            }

            $this->Cell(30, 7, UTF8_decode($key), 'B', 0, 'L');
            $this->Cell(2, 7, '', 'B');
            $border = $key === 'Montant total TTC' ? '' : 'B';

            $this->Cell(44, 7, UTF8_decode($value), $border, (bool)$border, 'R');
        }

    }


    function Footer()
    {
        $this->AddFont('Helvetica', '', 'helvetica.php');
        $this->SetFont('Helvetica', 'B', 8);
        $this->SetY(-12);
        $this->SetX(2);
        $this->SetFont('Helvetica', '', 7);
        $this->Cell(
            206, 5,
            UTF8_decode(
                'NB: A: Exonéré, B: Taxable, C: Exportation de produits taxables, D: TVA régime d\'exception, E: Régime fiscal TPS, F: Réservé'
            ),
            0, 0,'C'
        );
//        return;
        $pied = $this->entreprise['ifu'] ? 'IFU : ' . $this->entreprise['ifu'] . ' ' : '';
        $pied .= $this->entreprise['rccm'] ? 'RCCM : ' . $this->entreprise['rccm'] . ' ' : '';
//        $pied .= $this->entreprise['rccm'] ? 'CNSS : ' . $this->entreprise['rccm'] . ' ' : '';
        $pied .= $this->entreprise['compte'] ? 'Compte N° : ' . $this->entreprise['compte'] . ' ' : '';

        $this->SetY(-7);
        $this->SetX(2);
        $this->SetDrawColor(7, 14, 255);
        $this->SetFillColor(7, 14, 255);
        $this->SetTextColor(255, 255, 255);

        $this->SetFont('Helvetica', 'IB', 8);

        $this->MultiCell(206, 7, UTF8_decode($pied), 0, 'C', true);
    }


    function SetAlpha($alpha, $bm = 'Normal')
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(['ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm]);
        $this->SetExtGState($gs);
    }

    function AddExtGState($parms)
    {
        $n = count($this->extgstates) + 1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc()
    {
        if (!empty($this->extgstates) && $this->PDFVersion < '1.4') {
            $this->PDFVersion = '1.4';
        }
        parent::_enddoc();
    }

    function _putextgstates()
    {
        for ($i = 1, $iMax = count($this->extgstates); $i <= $iMax; $i++) {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_out('<</Type /ExtGState');
            $parms = $this->extgstates[$i]['parms'];
            $this->_out(sprintf('/ca %.3F', $parms['ca']));
            $this->_out(sprintf('/CA %.3F', $parms['CA']));
            $this->_out('/BM ' . $parms['BM']);
            $this->_out('>>');
            $this->_out('endobj');
        }
    }

    function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_out('/ExtGState <<');
        foreach ($this->extgstates as $k => $extgstate) {
            $this->_out('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
        }
        $this->_out('>>');
    }

    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }

}
