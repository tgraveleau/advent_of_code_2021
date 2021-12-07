<?php
$string = include("data.php");
$data = explode("\n", $string);
var_dump($data);
$nbtotal = count($data);
echo "Nb lignes : $nbtotal\n";

$pos = [
    'x' => 0,
    'y' => 0,
    'aim' => 0
];

foreach ($data as $i => $d) {
    $step = preg_split('/\s+/', $d);
    if ($i <10) {
        var_dump($step);
        var_dump($d);
    }
    switch ($step[0]) {
        case 'forward':
            $pos['x'] += $step[1];
            $pos['y'] += $step[1]*$pos['aim'];
        break;
        case 'up':
            $pos['aim'] -= $step[1];
        break;
        case 'down':
            $pos['aim'] += $step[1];
        break;
        default:
            echo "ERR -- $step[0] $step[1]\n";
            exit(1);
    }
}

echo "x : ".$pos['x'].", y : ".$pos['y'].", res : ".$pos['x']*$pos['y']."\n";

?>