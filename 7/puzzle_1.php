<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$data = explode(",", $string);
$max = max($data);

$lessExpensive = null;
for ($i=0; $i<=$max; $i++) {
    $cost = cost($data,$i);
    // echo "i : $i, cost : $cost\n";
    if (null === $lessExpensive) {
        $lessExpensive = [
            'number' => $i,
            'cost' => $cost,
        ];
    } else {
        if ($lessExpensive['cost'] > $cost) {
            $lessExpensive['number'] = $i;
            $lessExpensive['cost'] = $cost;
        }
    }
}

echo "RES : ".$lessExpensive['number'].", cout : ".$lessExpensive['cost']."\n";

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";

function cost($array, $value) {
    $cost = 0;
    foreach ($array as $a) {
        $cost += abs($a-$value);
        // echo "--- $a vs $value, $cost\n";
    }
    return $cost;
}
?>