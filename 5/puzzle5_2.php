<?php
$debut = microtime(true);
$string = include("data.php");
$SIZE = 1000;
// $string = include("data_test.php");
// $SIZE = 10;
$data = explode("\n", $string);


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
    } else if ($deltaY == $deltaY) {
        $xasc = ($vent['a']['x'] < $vent['b']['x']);
        $yasc = ($vent['a']['y'] < $vent['b']['y']);
        $i = $j = 0;
        // echo "diag : ($deltaX, $deltaY)\n";
        // echo "xasc : ".($xasc ? "O" : "N")."\n";
        // echo "yasc : ".($yasc ? "O" : "N")."\n";
        while (abs($i) <=$deltaX) {
            // echo "(".($vent['a']['x']+$i).",".($vent['a']['y']+$i).")";
            $map[($vent['a']['x']+$i)][($vent['a']['y']+$j)]++;
            $i = $xasc ? $i+1 : $i-1;
            $j = $yasc ? $j+1 : $j-1;
        }
        /*for ($i=0; $i<($deltaX+1); $i++) {
            echo "(".($x+$i).",".($y+$i).")";
            $map[($x+$i)][($y+$i)]++;
        }*/
        // echo "\n";
    } else {
        echo "bump ($deltaX,$deltaY)\n";
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
    for ($j=0; $j<$SIZE; $j++) {
        // echo "($i,$j) = ".$map[$i][$j];
        if ($map[$i][$j] >= 2) {
            // echo " oui";
            $count++;
        }
        // echo "\n";
    }
}

echo "NB : $count\n";

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";

function displayVent($vent) {
    echo "(".$vent['a']['x'].",".$vent['a']['y'].") -> (".$vent['b']['x'].",".$vent['b']['y'].")\n";
}
?>