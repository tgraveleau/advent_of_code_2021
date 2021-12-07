<?php
$string = include("data.php");
$data = preg_split('/[\s]+/', $string);
$nbtotal = count($data);
//var_dump($data);

$oxygen =  bindec(eliminate($data, 0, true));
$co2 =  bindec(eliminate($data, 0, false));

echo "okxy : $oxygen, co2 : $co2, res : ".$oxygen*$co2."\n";

function eliminate($array, $pos, $keepHigher) {
    if (count($array) == 1) {
        echo "$keepHigher : $array[0]\n";
        return $array[0];
    }

    $ones = [];
    $zeros = [];
    $countOne = 0;
    $countZero = 0;

    foreach ($array as $d) {
        if ($d[$pos] == '1') {
            $countOne++;
            $ones[] = $d;
        } else {
            $countZero++;
            $zeros[] = $d;
        }
    }
    echo "pos : $pos, 1 : $countOne, 0 : $countZero\n";
    
    if ($keepHigher) {
        if ($countOne >= $countZero) {
            return eliminate($ones, $pos+1, $keepHigher);
        } else {
            return eliminate($zeros, $pos+1, $keepHigher);
        }
    } else {
        if ($countOne < $countZero) {
            return eliminate($ones, $pos+1, $keepHigher);
        } else {
            return eliminate($zeros, $pos+1, $keepHigher);
        }
    }
}

?>