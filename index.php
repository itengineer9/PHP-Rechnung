<?php

require 'classes/Rechnung.php';

$absender_arr = [
    'Firma'    =>   'KIS-Computerservices',
    'Inhaber'  =>   'A.Alahamd',
    'Strasse'  =>   'KurtSchumastr.144',
    'Plz'      =>   '45881',
    'Ort'      =>   'Gel.',
];

$kunde_arr = [
    'Anrede'   =>   'Herr',
    'Name'     =>   'AHmad .Alahamd',
    'Strasse'  =>   'Hofweg4',
    'PlzOrt'   =>   '10115 Berlin',
];

$contact_arr = [
    'Telefon'   =>   '041017898736',
    'Telefax'   =>   '-------',
    'Email'     =>   'info@kis-com.de',
    'Internet'  =>   'www.kis-com.de',
    'Bank'      =>   'Postbank Hamburg',
    'Ust-IDNr'  =>   'DE XXXXXXXXXXXXXX',
    'Kto'       =>   '545645881',
    'BLZ'       =>   '200 100 20',
];

$vorgang_arr= [
    'Kunden-Nr'     =>   'D0000290',
    'User Vorgang'  =>   'Hofweg4',
    'Datum'         => date('d.m.yy'),
];

$detailsTitle_arr = [
    ['Artikel'  =>   'Service am 24.12.2009',
    'Menge'    =>   1.25,
    'Einheit'  =>   'Std',
    'MwSt'     =>   19,
    'E-Preis'  =>   49,
    ],
    ['Artikel'  =>   'Service am 26.10.2012',
    'Menge'    =>   2.25,
    'Einheit'  =>   'Tag',
    'MwSt'     =>   19,
    'E-Preis'  =>   69,
    ],
    ['Artikel'  =>   'Service am 20.01.2014',
    'Menge'    =>   3.5,
    'Einheit'  =>   'Std',
    'MwSt'     =>   19,
    'E-Preis'  =>   39,
    ],
    [
    'Artikel'  =>   'Service am 16.12.2010',
    'Menge'    =>   1,
    'Einheit'  =>   'Jahr',
    'MwSt'     =>   19,
    'E-Preis'  =>   156,
    ]
];

$rech = new Rechnung();
$rech->AddPage();
$rech->SetFont('times','i',12);
$rech->addLogo('logo.png');
$rech->addAbsender($absender_arr);
$rech->Ln();
$rech->addContact($contact_arr);
$rech->Ln();
$rech->addKunde($kunde_arr);
$rech->addVorgang($vorgang_arr);

$liefer= clone $rech;

$rech->addDetailsTitle($detailsTitle_arr);
$rech->addTotal($detailsTitle_arr);
$rech->Output();

$liefer->addLiefer();
$liefer->Output('F','Lieferant.pdf');