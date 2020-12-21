<?php

namespace AppBundle\Service;

use NumberFormatter;

class PdfOld extends Fpdf
{

    protected $fact;
    protected $regle;
    protected $entreprise;
    protected $ref;
    protected $info;
    protected $detail;
    protected $facture;
    var $extgstates = array();

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4', $ent, $ref, $info, $detail, $facture)
    {
        parent::__construct($orientation, $unit, $size);
        $this->entreprise = $ent;
        $this->ref = $ref;
        $this->info = $info;
        $this->detail = $detail;
        $this->facture = $facture;
    }

    // En-tête
    function Header()
    {
        $this->SetFont('Helvetica', 'B', 14);
        $this->AddFont('Helveticai', '', 'helveticai.php');
        $this->AddFont('Helvetica', '', 'helvetica.php');
        $this->SetY(10);
        $h = $this->PageNo() == 1 ? 0 : 155;
        $this->Image($this->entreprise['logo'], 15, 5, 30);
        $this->Cell(35);
        $this->Cell($h, 5, UTF8_decode(strtoupper($this->entreprise['raison_sociale'])), 0, 0, 'R');
        $this->Ln();
        $this->Cell(35);
        $this->SetFont('Helvetica', 'IB', 10);
        $this->Cell($h, 4, UTF8_decode($this->entreprise['adresse'] ), 0, 0, 'R');
        $this->Ln();
        $this->Cell(35);
        $this->Cell($h, 4, UTF8_decode($this->entreprise['contact']), 0, 0, 'R');
        if ($this->entreprise['email'] and $this->entreprise['site']) {
            $this->Ln();
            $this->Cell(35);
            $this->Cell($h, 4, UTF8_decode($this->entreprise['email'] . ' - ' . $this->entreprise['site']), 0, 0, 'R');
        }else{
            if ($this->entreprise['email']) {
                $this->Ln();
                $this->Cell(35);
                $this->Cell($h, 4, UTF8_decode($this->entreprise['email']), 0, 0, 'R');
            }
            if ($this->entreprise['site']) {
                $this->Ln();
                $this->Cell(35);
                $this->Cell($h, 4, UTF8_decode($this->entreprise['site']), 0, 0, 'R');
            }
        }
        if ($this->facture['pro_format_id'] != 0 && $this->facture['pro_format_id']['bcmd']) {
            $this->Ln();
            $this->Ln();
            $this->Cell(35);
            $this->SetFont('Helvetica', 'B', 10); // police italic gras et taille
            $this->Cell($h, 4, UTF8_decode("Bon Cmd N° ". $this->facture['pro_format_id']['bcmd']), 0, 0, 'R');
            $this->Ln(7);
        }else{
            $this->Ln(10);
        }

    }






    function Footer()
    {
        $this->SetY(-10);
        $config = ['couleur' => 'blue|150 , 120, 200'];
        $color = explode('|', $config['couleur']);
        $second = explode(', ', $color[1]);
        // Pied de page
        $this->AddFont('Helvetica', '', 'helvetica.php');
        $this->SetFont('Helvetica', 'IB', 8);
        $this->SetX(0);
        $this->SetFillColor((int) $second[0], (int) $second[1], (int) $second[2]);
        $this->SetDrawColor(0, 48, 255);
        $this->Cell(300, 1, '', 0, 0, 'C', true);
        $this->SetTextColor(0);
        $this->SetX(0);
        $pied = $this->entreprise['ifu'] ? 'IFU : ' . $this->entreprise['ifu'] . ' ' : '';
        $pied .= $this->entreprise['rccm'] ? 'RCCM : ' . $this->entreprise['rccm'] . ' ' : '';
        $pied .= $this->entreprise['cnss'] ? 'CNSS : ' . $this->entreprise['cnss'] . ' ' : '';
        $pied .= $this->entreprise['compte'] ? 'Compte N° : ' . $this->entreprise['compte'] . ' ' : '';
        $this->MultiCell(0, 10, UTF8_decode($pied), 0, 'C', false);
    }

    function FancyTable($tete, $header, $head, $headers){
        //$this->SetY(42); // permet de définir une hauteur par rapport au haut
        $config = [
            'couleur' => 'blue|150 , 120, 200',
            'devise' => 'XOF'
        ];
        $color = explode('|', $config['couleur']);

        $first = explode(', ', $color[0]);
        $second = explode(', ', $color[1]);
        $this->SetFont('Helvetica', 'B', 12);
        $this->SetX(12); // permet de définir le début de la ligne
        $this->Cell(153, 8, UTF8_decode('Facture N° '. $this->ref), 0, 0, 'L');
        if ($this->facture['etat'] ==  'NR' && $this->facture['date_buttoir'] != '1111-11-11') {
            $this->SetFont('Helvetica', 'IB', 10); // police italic gras et taille
            $this->Cell(32, 10, UTF8_decode('A régler au plus tard le '. frenchDate($this->facture['date_buttoir'])), 0, 0, 'R');
        }
        $this->Ln(8); // saut de 8 lignes
        $this->SetX(12);
        $this->SetFont('Helvetica', 'B', 10);
        $this->SetFillColor(255); // (int) $first[0], (int) $first[1], (int) $first[2]
        $this->SetTextColor(0); // couleur de texte
        $this->SetDrawColor(0); // permet de modifier la couleur des traits du tableau
        $w = array(42, 123);
        for ($i = 0, $iMax = count($tete); $i < $iMax; $i++)
            $this->Cell($w[$i], 8, UTF8_decode($tete[$i]), 1, 0, 'C', true); // le true autorise le fond à prendre la couleur verte défini
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Helvetica', '', 10);
        $this->SetTextColor(0);
        $this->Cell($w[0], 10, UTF8_decode($this->info[0]), '1', 0, 'C', false);
        $this->Cell($w[1], 10, UTF8_decode($this->info[1]), '1', 0, 'C', false);
        if ($this->facture['pro_format_id'] != 0 &&  $this->facture['pro_format_id']['bcmd']) {
            $this->Image('frontend/img/'. $this->entreprise['qrc'], 178, 46, 18);
        }else{
            $this->Image('frontend/img/'. $this->entreprise['qrc'], 178, 41, 18);
        }
        $this->Ln();
        $this->Ln(3);
        $this->SetX(12);

        $this->SetFont('Helvetica', 'B', 10);
        $this->SetFillColor(255); // couleur verte
        $this->SetTextColor(0); // couleur de texte blache
        $this->SetDrawColor(0); // permet de modifier la couleur des traits du tableau
        $w = array(9, 107, 17, 25, 26);
        for ($i = 0, $iMax = count($header); $i < $iMax; $i++)
            $this->Cell($w[$i], 7, UTF8_decode($header[$i]), 1, 0, 'C', true);
        $this->Ln();
        $this->SetFont('Helvetica', '', 9);
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $i = 0;
        $fill = false;
        foreach ($this->detail as $value) {
            $prod = [
                'designation' => 'Produit ' . $i
            ];
            $prix_net = $value['cout_unitaire'] * (1- $value['red']/100);
            $i++;
            if (strlen($prod['designation']) > 65) {
                $produit = substr($prod['designation'], 0, 65) . '...';
            }else{
                $produit = $prod['designation'];
            }
            $qte = strlen($value['qte']) ==  1 ? '0' . $value['qte'] : $value['qte'];
            $this->SetX(12);
            $this->Cell($w[0], 6, $i, '1', 0, 'C', $fill);
            $this->Cell($w[1], 6, UTF8_decode($produit), '1', 0, 'J', $fill);
            $this->Cell($w[2], 6, $qte, '1', 0, 'C', $fill);
            $this->Cell($w[3], 6, number_format($prix_net, 0, ' ', ' '), '1', 0, 'R', $fill);
            $this->Cell($w[4], 6, number_format($value['qte'] * $prix_net, 0, ' ', ' '), '1', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->SetX(12);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        $this->Ln(3);
        $this->SetX(12);

        $this->SetFont('Helvetica', 'B', 9);
        $this->SetFillColor(255); // couleur verte
        $this->SetTextColor(0); // couleur de texte blache
        $this->SetDrawColor(0); // permet de modifier la couleur des traits du tableau
        $w = array(9, 23, 9, 23);
        for ($i = 0, $iMax = count($head); $i < $iMax; $i++)
            $this->Cell($w[$i], 7, UTF8_decode($head[$i]), 1, 0, 'C', true);
        $this->SetX(77);
        $h = array(23, 23, 23, 23, 27);
        for ($i = 0, $iMax = count($headers); $i < $iMax; $i++)
            $this->Cell($h[$i], 7, UTF8_decode($headers[$i]), 1, 0, 'C', true);
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Helvetica', '', 7);
        $this->SetTextColor(0);
        $this->Cell($w[0], 6,  'TVA', '1', 0, 'C', false);
        $this->Cell($w[1], 6, number_format($this->facture['mht'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->Cell($w[2], 6, $this->facture['tva'] . '%', 1, 0, 'C', false);
        $this->Cell($w[3], 6, number_format($this->facture['mont_tva'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->SetX(77);
        $this->Cell($h[0], 6, number_format($this->facture['mht'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->Cell($h[1], 6, '('.number_format($this->facture['remise'], 0, ' ', ' ') .')', 1, 0, 'C', false);
        $this->Cell($h[2], 6, number_format($this->facture['transport'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->Cell($h[3], 6, number_format($this->facture['emballage'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->Cell($h[4], 6, number_format($this->facture['nap'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->Ln();
        $this->SetX(12);
        $this->Cell($w[0], 6,  'AIB', '1', 0, 'C', false);
        $this->Cell($w[1], 6, number_format($this->facture['mht'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->Cell($w[2], 6, $this->facture['aib'] . '%', 1, 0, 'C', false);
        $this->Cell($w[3], 6, number_format($this->facture['mont_aib'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->SetX(77);
        $this->SetFont('Helvetica', 'IB', 10);
        $this->Cell(23, 6, UTF8_decode('Règlement'), 0, 1, 'L', false);
        $this->SetX(12);
        $this->SetFillColor(255); // couleur verte
        $this->SetTextColor(0); // couleur de texte blache
        $this->SetFont('Helvetica', 'B', 10);
        $this->Cell($w[0]+$w[1]+$w[2], 6, 'Total : ', 1, 0, 'R', true);
        $this->SetFont('Helvetica', '', 7);
        $this->SetTextColor(0);
        $this->Cell($w[3], 6, number_format($this->facture['mont_aib']+$this->facture['mont_tva'], 0, ' ', ' '), 1, 0, 'C', false);
        $this->SetX(77);
        $this->SetTextColor(0); // couleur de texte blache
        $this->SetFont('Helvetica', 'B', 10);
        $this->Cell($h[0], 6, 'Acompte : ', 1, 0, 'C', true);
        $this->SetFont('Helvetica', 'B', 8);
        $this->SetTextColor(0);
        $paye = $this->facture['paye'];
        $this->Cell($h[1]+$h[2], 6, number_format($paye, 0, ' ', ' '). ' ' . $config['devise'], 1, 0, 'C', false);
        $this->SetTextColor(0); // couleur de texte blache
        $this->SetFont('Helvetica', 'B', 10);
        $this->Cell($h[3], 6, 'R.A.P ', 1, 0, 'C', true);
        $this->SetFont('Helvetica', 'B', 8);
        $this->SetTextColor(0);
        $this->Cell($h[4], 6, number_format($this->facture['nap']-$paye, 0, ' ', ' '), 1, 0, 'C', false);
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Helvetica', 'IB', 10);
        $this->SetTextColor((int) $second[0], (int) $second[1], (int) $second[2]);
        $format = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
        $this->MultiCell(0, 7, UTF8_decode('Arrêter la présente facture à la somme de ') . $format->format(round($this->facture['nap'])) . ' ' . $config['devise'], 0, 'C');
        $this->SetTextColor(0);
        $this->Ln(3);
        $this->SetX(12);
        $this->SetTextColor(0); // couleur de texte blache
        $this->SetFont('Helvetica', 'B', 10);
        $this->Cell(70, 7, UTF8_decode('Mode de règlement'), 1, 0, 'L', true);
        $this->Ln();
        $this->SetX(12);
        $this->SetTextColor(0);
//        $valeur_paye = total_montant_mode('Espèce', $this->facture['id'], $_SESSION['exercice']['id'], $_SESSION['agence']['id'], $_SESSION['entreprise']['id'])['paye'];
        $valeur_paye = 25000;
        $this->SetFont('Helvetica', '', 9);
        $this->Cell(70, 6, UTF8_decode('Espèce : '), 1, 0, 'L', false);
        $this->SetFont('Helvetica', 'B', 8);
        $this->Cell(1, 6, number_format($valeur_paye, 0 , ' ', ' ') . ' ' . $config['devise'] . ' ', 0, 0, 'R', false);
        $this->SetFont('Helvetica', 'IB', 10);
        $this->Cell(100, 6, UTF8_decode('La Facturation,'), 0, 0, 'R', false);
        $this->Ln();
        $this->SetX(12);
//        $valeur_paye = total_montant_mode('Chèque', $this->facture['id'], $_SESSION['exercice']['id'], $_SESSION['agence']['id'], $_SESSION['entreprise']['id'])['paye'];
        $valeur_paye = 21544;
        $this->SetFont('Helvetica', '', 9);
        $this->Cell(70, 6, UTF8_decode('Chèque : '), 1, 0, 'L', false);
        $this->SetFont('Helvetica', 'B', 8);
        $this->Cell(1, 6, number_format($valeur_paye, 0 , ' ', ' ') . ' ' . $config['devise'] . ' ', 0, 0, 'R', false);
        $this->Ln();
        $this->SetX(12);
//        $valeur_paye = total_montant_mode('Virement', $this->facture['id'], $_SESSION['exercice']['id'], $_SESSION['agence']['id'], $_SESSION['entreprise']['id'])['paye'];
        $valeur_paye = 25465;
        $this->SetFont('Helvetica', '', 9);
        $this->Cell(70, 6, UTF8_decode('Virement Banquaire : '), 1, 0, 'L', false);
        $this->SetFont('Helvetica', 'B', 8);
        $this->Cell(1, 6, number_format($valeur_paye, 0 , ' ', ' ') . ' ' . $config['devise'] . ' ', 0, 0, 'R', false);
        $this->Ln();
        $this->SetX(12);
//        $valeur_paye = total_montant_mode('Money Mobile', $this->facture['id'], $_SESSION['exercice']['id'], $_SESSION['agence']['id'], $_SESSION['entreprise']['id'])['paye'];
        $valeur_paye = 21648;
        $this->SetFont('Helvetica', '', 9);
        $this->Cell(70, 6, UTF8_decode('Money Mobile : '), 1, 0, 'L', false);
        $this->SetFont('Helvetica', 'B', 8);
        $this->Cell(1, 6, number_format($valeur_paye, 0 , ' ', ' ') . ' ' . $config['devise'] . ' ', 0, 0, 'R', false);
        //$this->Ln(10);
        $this->SetFont('Helvetica', 'IB', 8);
        $this->Cell(100, 6, UTF8_decode($this->facture['signataire']), 0, 0, 'R', false);
    }

    function SetAlpha($alpha, $bm = 'Normal')
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(array('ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm));
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
        if (!empty($this->extgstates) && $this->PDFVersion < '1.4')
            $this->PDFVersion = '1.4';
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
        foreach ($this->extgstates as $k => $extgstate)
            $this->_out('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
        $this->_out('>>');
    }

    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }

}
