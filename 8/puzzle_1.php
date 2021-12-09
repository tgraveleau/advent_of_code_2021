<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$data = explode("\n", $string);

$DIGITS_SIZE = [
    1 => 2,
    4 => 4,
    7 => 3,
    8 => 7,
];

$count = 0;
foreach ($data as $lineBrut) {
    $line = array_map('trim', explode('|',$lineBrut));
    $digits = explode(' ', $line[1]);
    foreach ($digits as $digit) {
        if (in_array(strlen($digit), $DIGITS_SIZE)) {
            $count++;
        }
    }
}

echo "Nb : $count\n";

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>