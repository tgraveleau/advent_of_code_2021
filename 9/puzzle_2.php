<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$dataBrut = preg_split('/[\s]+/', $string);

$data = [];
foreach ($dataBrut as $i => $db) {
    $tmp = array_map('intval', str_split($db));
    foreach($tmp as $j => $value) {
        $data[$i][$j] = [
            'value' => $value,
            'marked' => 9 == $value ? true : false,
        ];
    }
}

$largestBassins = [];
$width = count($data);
for ($i=0; $i<$width; $i++) {
    $height = count($data[$i]);
    for ($j=0; $j<$height; $j++) {
        $current = $data[$i][$j];
        if (!$current['marked']) {
            // check bassin
            $bassin = bassinValue($data, $i, $j);
            echo "bassin : ".$bassin."\n";

            // ajout aux bassins
            $nbBassins = count($largestBassins);
            if ($nbBassins < 3) {
                $largestBassins[] = $bassin;
            } else {
                $min = min($largestBassins);
                if ($min < $bassin) {
                    $largestBassins[array_search($min, $largestBassins)] = $bassin;
                }
            }
        }
    }
}

echo "Res : ".$largestBassins[0]."*".$largestBassins[1]."*".$largestBassins[2]." : ".array_product($largestBassins)."\n";

function bassinValue(&$array, $x, $y) {
    $current = $array[$x][$y];

    if ($current['marked']) {
        return 0;
    }
    $array[$x][$y]['marked'] = true;
    $res = 1;
    // echo "value : ".$res."\n";

    // à gauche
    if ($x != 0) {
        $res += bassinValue($array, $x-1, $y);
    }
    // à droite
    if ($x != (count($array)-1)) {
        $res += bassinValue($array, $x+1, $y);
    }
    // en haut
    if ($y != 0) {
        $res += bassinValue($array, $x, $y-1);
    }
    // en bas
    if ($y != (count($array[0])-1)) {
        $res += bassinValue($array, $x, $y+1);
    }

    return $res;
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>