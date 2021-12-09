<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$dataBrut = preg_split('/[\s]+/', $string);
$data = [];
foreach ($dataBrut as $db) {
    $data[] = array_map('intval', str_split($db));
}

$sum = 0;
$width = count($data);
for ($i=0; $i<$width; $i++) {
    $height = count($data[$i]);
    for ($j=0; $j<$height; $j++) {
        if (isLowest($data, $i, $j)) {
            echo "$i, $j : ".$data[$i][$j]."\n";
            $sum += $data[$i][$j]+1;
        }
    }
}

echo "Sum : $sum\n";

function isLowest($array, $x, $y) {
    if ($x != 0 && $array[$x-1][$y] <= $array[$x][$y]) {
        return false;
    } else {}
    if ($x != (count($array)-1) && $array[$x+1][$y] <= $array[$x][$y]) {
        return false;
    }
    if ($y != 0 && $array[$x][$y-1] <= $array[$x][$y]) {
        return false;
    }
    if ($y != (count($array[0])-1) && $array[$x][$y+1] <= $array[$x][$y]) {
        return false;
    }
    return true;
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>