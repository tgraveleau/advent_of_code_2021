<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$dataBrut = array_map('trim', explode("\n", $string));
$nbDataBrut = count($dataBrut);

// Process polymer
$polymer = str_split($dataBrut[0]);
$nbPolymer = count($polymer);
$lastPolymer = $polymer[$nbPolymer-1];
// Va sauvegarder les duos de caractères en clé et le nombre de fois où le duo est présent en valeur
$polymerData = [];
for ($i=1; $i<$nbPolymer; $i++) {
    $duo = $polymer[$i-1].$polymer[$i];
    if (array_key_exists($duo, $polymerData)) {
        $polymerData[$duo]++;
    } else {
        $polymerData[$duo] = 1;
    }
}

// Process pairs
$pairs = [];
for ($i=2; $i<$nbDataBrut; $i++) {
    $lineParsed = explode(' -> ', $dataBrut[$i]);
    $pairs[$lineParsed[0]] = $lineParsed[1];
}

// Polymerisation
$nbStep = 40;
for ($step=0; $step<$nbStep; $step++) {
    $polymerData = polymerisation($polymerData, $pairs);
}

// Count
$charsCount = [];
foreach ($polymerData as $p => $nbOccurence) {
    $chars = str_split($p);
    if (!array_key_exists($chars[0], $charsCount)) {
        $charsCount[$chars[0]] = $nbOccurence;
    } else {
        $charsCount[$chars[0]] += $nbOccurence;
    }
}
// On ajoute 1 au dernier caractère
$charsCount[$lastPolymer]++;

echo "Res : ".(max($charsCount)-min($charsCount))."\n";

function polymerisation($polymerData, $pairs) {
    $newPolymerData = [];
    foreach ($polymerData as $duo => $nbOccurence) {
        $pair = str_split($duo);
        $newduo1 = null;
        $newduo2 = null;
        // Si on a une polymerisation
        if (array_key_exists($duo, $pairs)) {
            // On ajoute le nouveau duo
            $newduo1 = $pair[0].$pairs[$duo];
            $newduo2 = $pairs[$duo].$pair[1];
            if (array_key_exists($newduo1, $newPolymerData)) {
                $newPolymerData[$newduo1] += $nbOccurence;
            } else {
                $newPolymerData[$newduo1] = $nbOccurence;
            }
            if (array_key_exists($newduo2, $newPolymerData)) {
                $newPolymerData[$newduo2] += $nbOccurence;
            } else {
                $newPolymerData[$newduo2] = $nbOccurence;
            }
        } else {
            // On ajoute le duo initial
            if (array_key_exists($duo, $newPolymerData)) {
                $newPolymerData[$duo] += $nbOccurence;
            } else {
                $newPolymerData[$duo] = $nbOccurence;
            }
        }
    }
    return $newPolymerData;
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>