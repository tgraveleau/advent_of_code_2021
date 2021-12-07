<?php
$debut = microtime(true);
$string = include("data.php");
$data = array_map('intval', explode(",", $string));

$NB_DAYS = 512;
$detailFish = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
];

foreach ($data as $fish) {
    $detailFish[$fish]++;
}

$daysRemaining = $NB_DAYS;
while ($daysRemaining != 0) {
    // echo "Remain : $daysRemaining\n";
    $tmp = $detailFish;

    $detailFish[8] = $tmp[0];
    $detailFish[7] = $tmp[8];
    $detailFish[6] = $tmp[7]+$tmp[0];
    $detailFish[5] = $tmp[6];
    $detailFish[4] = $tmp[5];
    $detailFish[3] = $tmp[4];
    $detailFish[2] = $tmp[3];
    $detailFish[1] = $tmp[2];
    $detailFish[0] = $tmp[1];
    
    $daysRemaining--;
}

echo "Nb fish : ".array_sum($detailFish)."\n";
$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";

?>