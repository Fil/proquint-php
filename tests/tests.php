<?php

require_once 'proquint.php';

$proquint = new Proquint;

$t = array(
  chr(0).chr(0) => 'babab',
  "\x7f\x00\x00\x01" => 'lusab-babad',
  chr(128).chr(0).chr(0).chr(1) => 'mabab-babad',
  "vive l’été !!" => 'linon-linoj-fados-vapab-nolag-pojuh-savon-sapob-fahod'
);

$t2 =  array(
'127.0.0.1' => 'lusab-babad',
'63.84.220.193' => 'gutih-tugad',
'63.118.7.35' => 'gutuk-bisog',
'140.98.193.141' => 'mudof-sakat',
'64.255.6.200' => 'haguz-biram',
'128.30.52.45' => 'mabiv-gibot',
'147.67.119.2' => 'natag-lisaf',
'212.58.253.68' => 'tibup-zujah',
'216.35.68.215' => 'tobog-higil',
'216.68.232.21' => 'todah-vobij',
'198.81.129.136' => 'sinid-makam',
'12.110.110.204' => 'budov-kuras'
);

foreach($t2 as $i => $p) {
    $b = join('',array_map('chr', explode('.', $i)));
    $t[$b] = $p;
}


foreach($t as $b => $p) {
    $c = $proquint->Encode($b);
    if ($c !== $p) die('error encoding '.var_export($c, true).', should give '.$p);
    $c = $proquint->Decode($p);
    if ($c !== $b) die('error decoding '.var_export([$b,$p,$c], true));
}

