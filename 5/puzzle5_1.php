<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$data = explode("\n", $string);

$SIZE = 1000;

// VENT
$vents = [];
foreach ($data as $line) {
    $points = explode(" -> ",$line);
    $a = array_map('intval', explode(',', $points[0]));
    $b = array_map('intval', explode(',', $points[1]));
    $vents[] = [
        'a' => [
            'x' => $a[0],
            'y' => $a[1],
        ],
        'b' => [
            'x' => $b[0],
            'y' => $b[1],
        ],
    ];
}
//var_dump(array_slice($vents, 0, 5));

// MAP
$map = [];
$width = $height = $SIZE;
for ($i=0; $i<$width; $i++) {
    for ($j=0; $j<$height; $j++) {
        $map[$i][$j] = 0;
    }
}

foreach ($vents as $vent) {
    if ($vent['a']['x'] < $vent['b']['x']) {
        $deltaX = $vent['b']['x'] - $vent['a']['x'];
        $x = $vent['a']['x'];
    } else {
        $deltaX = $vent['a']['x'] - $vent['b']['x'];
        $x = $vent['b']['x'];
    }
    if ($vent['a']['y'] < $vent['b']['y']) {
        $deltaY = $vent['b']['y'] - $vent['a']['y'];
        $y = $vent['a']['y'];
    } else {
        $deltaY = $vent['a']['y'] - $vent['b']['y'];
        $y = $vent['b']['y'];
    }
    // echo "deltaX : $deltaX, deltaY : $deltaY\n";
    // echo "from ($x,$y)\n";

    if (0 == $deltaX) {
        for ($curY=$y; $curY<($y+$deltaY+1); $curY++) {
            $map[$x][$curY]++;
        }
    } else if (0 == $deltaY) {
        for ($curX=$x; $curX<($x+$deltaX+1); $curX++) {
            $map[$curX][$y]++;
        }
    }
}

$count = 0;
// foreach ($map as $line) {
//     foreach ($line as $el) {
//         if ($el >= 2) {
//             $count++;
//         }
//     }
// }
for ($i=0; $i<$SIZE; $i++) {
    // echo "$i - ";
    for ($j=0; $j<$SIZE; $j++) {
        // echo "$j, ";
        // echo "($i,$j) = ".$map[$i][$j];
        if ($map[$i][$j] >= 2) {
            // echo " oui";
            $count++;
        }
        // echo "\n";
    }
    // echo "\n";
}

echo "NB : $count\n";

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";

function displayVent($vent) {
    echo "(".$vent['a']['x'].",".$vent['a']['y'].") -> (".$vent['b']['x'].",".$vent['b']['y'].")\n";
}
?>