<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$dataBrut = preg_split('/[\s]+/', $string);
$octopuses = [];
foreach ($dataBrut as $db) {
    $octopuses[] = array_map('intval', str_split($db));
}

$NB_LIGNES = count($octopuses);
$NB_COLONNES = count($octopuses[0]);

$nbDays = 0;
while (!allFlashed($octopuses)) {
    $nbDays++;
    // Energy +1
    for ($i=0; $i<$NB_LIGNES; $i++) {
        for ($j=0; $j<$NB_COLONNES; $j++) {
            $octopuses[$i][$j]++;
        }
    }
    // Flash
    for ($i=0; $i<$NB_LIGNES; $i++) {
        for ($j=0; $j<$NB_COLONNES; $j++) {
            $nbFlashes += flash($octopuses, $i, $j, $NB_LIGNES, $NB_COLONNES);
        }
    }
}

echo "Day : $nbDays\n";

function allFlashed($octopuses) : bool {
    foreach ($octopuses as $line) {
        foreach ($line as $octo) {
            if ($octo != 0) {
                return false;
            }
        }
    }
    return true;
}

function flash(&$octopuses, $i, $j, $nbLignes, $nbColonnes, $neighborHasFlashed = false) : int {
    // S'il n'a pas déjà flashé et qu'on vient de flashé à côté de lui, il gagne de l'énérgie
    if ($octopuses[$i][$j] != 0 && $neighborHasFlashed) {
        $octopuses[$i][$j]++;
    }
    // Pas de flash
    if ($octopuses[$i][$j] < 10) {
        return 0;
    }
    // On met à 0 pour le jour d'après et pour ne pas reflasher
    $octopuses[$i][$j] = 0;
    // On ajoute 1 et on flash les voisins
    $nbFlash = 1;
    // à gauche
    if ($i != 0) {
        $nbFlash += flash($octopuses, $i-1, $j, $nbLignes, $nbColonnes, true);
        // en haut à gauche
        if ($j != 0) {
            $nbFlash += flash($octopuses, $i-1, $j-1, $nbLignes, $nbColonnes, true);
        }
    }
    // à droite
    if ($i != ($nbLignes-1)) {
        $nbFlash += flash($octopuses, $i+1, $j, $nbLignes, $nbColonnes, true);
        // en bas à droite
        if ($j != ($nbColonnes-1)) {
            $nbFlash += flash($octopuses, $i+1, $j+1, $nbLignes, $nbColonnes, true);
        }
    }
    // en haut
    if ($j != 0) {
        $nbFlash += flash($octopuses, $i, $j-1, $nbLignes, $nbColonnes, true);
        // en haut à droite
        if ($i != ($nbLignes-1)) {
            $nbFlash += flash($octopuses, $i+1, $j-1, $nbLignes, $nbColonnes, true);
        }
    }
    // en bas
    if ($j != ($nbColonnes-1)) {
        $nbFlash += flash($octopuses, $i, $j+1, $nbLignes, $nbColonnes, true);
        // en bas à gauche
        if ($i != 0) {
            $nbFlash += flash($octopuses, $i-1, $j+1, $nbLignes, $nbColonnes, true);
        }
    }
    return $nbFlash;
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>