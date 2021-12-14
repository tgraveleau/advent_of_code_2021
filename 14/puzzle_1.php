<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$dataBrut = array_map('trim', explode("\n", $string));
$nbDataBrut = count($dataBrut);

$polymer = $dataBrut[0];

$pairs = [];
for ($i=2; $i<$nbDataBrut; $i++) {
    $lineParsed = explode(' -> ', $dataBrut[$i]);
    $pairs[$lineParsed[0]] = $lineParsed[1];
}

// Polymerisation
$nbStep = 10;
for ($step=0; $step<$nbStep; $step++) {
    $polymer = polymerisation($polymer, $pairs);
}

// Count
$charsCount = [];
$polymerArray = str_split($polymer);
foreach ($polymerArray as $p) {
    if (!array_key_exists($p, $charsCount)) {
        $charsCount[$p] = 1;
    } else {
        $charsCount[$p]++;
    }
}

echo "Res : ".(max($charsCount)-min($charsCount))."\n";

function polymerisation($polymer, $pairs) {
    $polymerArray = str_split($polymer);
    $newPolymer = [];
    foreach ($polymerArray as $i => $p) {
        if (0 == $i) {
            $newPolymer[] = $p;
        } else {
            $pair = $polymerArray[$i-1].$p;
            // Si on a trouvé une paire de polymerisation avec le caractère d'avant concaténé au courant
            if (array_key_exists($pair, $pairs)) {
                // On l'ajoute à notre nouveau
                $newPolymer[] = $pairs[$pair];
            }
            // Dans tous les cas, on ajoute le polymere courant
            $newPolymer[] = $p;
        }
    }
    return implode($newPolymer);
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>