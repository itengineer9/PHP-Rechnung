<?php

require 'fpdf.php';
class Rechnung extends FPDF{
    /**
     * Add the Logo Picture in the left corner
     * @param File $datei Logo file
     */
    public function addLogo($datei) {
        if(file_exists($datei)){
            $this->Image($datei, 5, 2, 60, 40);
        }else{
            die("Fehler : Logodatei $datei nicht gefunden!");
        }
    }
    /**
     * Adding die AbsenderInformationen
     * @param array $data Absender Information
     */
    
    public function addAbsender(array $data) {
        $this->SetFont('Arial','BU', 10);
        $this->SetXY(10, 50);
        $str = $data['Firma'].', '.$data['Inhaber'].', '.
                $data['Strasse'].', '.$data['Plz'].' '.$data['Ort'];
        $this->Cell(150, 15, $str, 0);
    }
    
    
    
    public function addContact(array $contact) {
        $this->SetFont('Arial','', 11);
        $x=150;
        $y=50;
        $this->SetXY($x, $y);
        foreach ($contact as $key => $value) {        
            $this->Cell(50, 7,$key. ' '. $value,0,2);
        }
    }
    
    public function addKunde(array $kunde) {
        $this->SetFont('Arial','', 12);
        $x=10;
        $y=60;
        $this->SetXY($x, $y);
        foreach ($kunde as $key => $value) {        
            $this->Cell(strlen($value), 7,$value , 0 , 2);
        }
    }
    
    public function addVorgang($vorgang) {
        $this->SetFont('Arial','B',14);
        $this->SetXY(10, 140);
        $this->Cell(100, 10, 'Rechnung');
        
        $this->SetFont('Arial','B',12);
        $this->SetXY(150, 130);
        foreach ($vorgang as $key => $value) {
            $this->Cell(30, 7, $key);
            $this->Cell(20, 7,$value);
            $this->Ln();
            $this->SetX(150);
            
        }
    }
    public function addLiefer() {
        
        $this->SetFont('Arial','B',14);
        $this->SetXY(10, 120);
        $this->Cell(100, 10, 'Lieferant');
    }
    
    public function addDetailsTitle(array $data) {
        $this->tabelHeader();
        $this->SetFont('Arial', '', 10);
        
        foreach ($data as $key => $value) {
            $this->SetX(10);
            $this->Cell(100,7, 'Pos.'.($key+1).' '.$value['Artikel'], 'L');
            
            $menge = number_format($value['Menge'], 2, ',','');
            $this->Cell(15, 7, $menge, 'L',0,'R');
            
            $this->Cell(15, 7, $value['Einheit'], 'L');
            $this->Cell(15, 7, $value['MwSt'].'%','L',0,'R');
            
            $epreis= number_format($value['E-Preis'], 2, ',','.');
            $this->Cell(20, 7, $epreis, 'L',0,'R');
            
            $gpreis = number_format($value['E-Preis'] * $value['Menge'], 2, ',','.');
            $this->Cell(20, 7,$gpreis , 'LR',0,'R');
            $this->Ln();
            
        }
        $this->Cell(185, 7 , ' ', 'T');
    }
    /**
     * Make The Header of the Table
     */
    private function tabelHeader(){
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(10, 160);
        
        $this->Cell(100,7, 'Artikel oder Leistung', 'LTB');
        $this->Cell(15, 7, 'Menge', 'TB');
        $this->Cell(15, 7, 'Einheit', 'TB');
        $this->Cell(15, 7, 'MwSt', 'TB');
        $this->Cell(20, 7, 'E-Preis', 'TB');
        $this->Cell(20, 7, 'G-Preis', 'RTB');
        $this->Ln();
    }
    
    public function addTotal(array $data) {
        $gpreis = 0;
        $this->Ln();
        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(140, $this->GetY());   
        $this->Cell(35,7, 'Nettobetrag');
        foreach ($data as $key => $value) {
            $gpreis += $value['E-Preis'] * $value['Menge'];
        }
        $gp = number_format($gpreis, 2, ',','.');
        $this->Cell(20, 7,$gp , '',0,'R');
        $this->Ln();
        $this->SetXY(100, $this->GetY());   
        $this->Cell(35,7, 'MwSt = 19 %');
        $this->Cell(20, 7,$gp , '',0,'R');
        $this->Cell(20, 7,$gpreis*0.19 , '',0,'R');
        $this->Cell(20, 7,$gpreis+($gpreis*0.19) , '',0,'R');
        $this->Ln();
        $this->SetXY(140, $this->GetY());  
        $this->Cell(30, 7,'The Total', '',0,'L');
        $this->Cell(25, 7,$gpreis+($gpreis*0.19) , '',0,'R');
    }
}
