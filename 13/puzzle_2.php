<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$dataBrut = array_map('trim', explode("\n", $string));

$dots = [];
$width = 0;
$height = 0;
$iData = 0;
while ($dataBrut[$iData] !== '') {
    $coordonnees = explode(",",$dataBrut[$iData]);
    $x = $coordonnees[0];
    if ($x > $width) {
        $width = $x;
    }
    $y = $coordonnees[1];
    if ($y > $height) {
        $height = $y;
    }
    // echo "x: $x, y: $y\n";
    $dots[] = $dataBrut[$iData];
    $iData++;
}

// echo "h : $height, w : $width\n";
$transparent = [];
for ($i=0; $i<=$width; $i++) {
    $transparent[] = [];
    for ($j=0; $j<=$height; $j++) {
        $transparent[$i][$j] = in_array("$i,$j", $dots);
    }
}

// On passe aux folding
$iData ++;
while (null != $dataBrut[$iData]) {
    $fold = fold($transparent, $dataBrut[$iData], $width, $height);
    $transparent = $fold['transparent'];
    $width = $fold['width'];
    $height = $fold['height'];
    // display($transparent, $width, $height);
    $iData ++;
}

display($transparent, $width, $height);
// Count
$count = 0;
for ($i=0; $i<=$width; $i++) {
    for ($j=0; $j<=$height; $j++) {
        if ($transparent[$i][$j]) {
            $count++;
        }
    }
}
echo "N : $count\n";

function fold($transparent, $instruction, $width, $height) {
    // echo $instruction."\n";
    $instructionParsed = explode("=", str_replace("fold along ", "", $instruction));
    $newTransparent = [];
    $newWidth = $width;
    $newHeight = $height;
    $axe = $instructionParsed[1];
    if ($instructionParsed[0] == "x") {
        for ($i=0; $i<$axe; $i++) {
            $newTransparent[] = [];
            for ($j=0; $j<=$height; $j++) {
                $newTransparent[$i][$j] = ($transparent[$i][$j] || $transparent[$width-$i][$j]);
            }
        }
        $newWidth = $axe-1;
    } else {
        for ($i=0; $i<=$width; $i++) {
            $newTransparent[] = [];
            for ($j=0; $j<$axe; $j++) {
                $newTransparent[$i][$j] = ($transparent[$i][$j] || $transparent[$i][$height-$j]);
            }
        }
        $newHeight = $axe-1;
    }
    return [
        'transparent' => $newTransparent,
        'width' => $newWidth,
        'height' => $newHeight,
    ];
}

function display($transparent, $width, $height) {
    for ($j=0; $j<=$height; $j++) {
        for ($i=0; $i<=$width; $i++) {
            echo ($transparent[$i][$j] ? '#' : '.')." ";
        }
        echo "\n";
    }
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>