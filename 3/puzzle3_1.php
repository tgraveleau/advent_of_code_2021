<?php
$string = include("data.php");
$data = preg_split('/[\s]+/', $string);
$nbtotal = count($data);
//var_dump($data);

$nbBit = 12;
$gamma = [];
$epsilon = [];

for ($i=0; $i<$nbBit; $i++) {
    $countOne = 0;
    $countZero = 0;

    foreach ($data as $d) {
        if ($d[$i] == '1')
            $countOne++;
        else
            $countZero++;
    }

    if ($countOne > $countZero) {
        $gamma[$i] = '1';
        $epsilon[$i] = '0';
    } else {
        $gamma[$i] = '0';
        $epsilon[$i] = '1';
    }

    echo "1 : $countOne, 0 : $countZero, $gamma[$i];$epsilon[$i]\n";
}

$g = implode($gamma);
$e = implode($epsilon);

echo "gamma : $g = ".bindec($g).", epsilon : $e = ".bindec($e).", power : ".bindec($g)*bindec($e)."\n";

?>