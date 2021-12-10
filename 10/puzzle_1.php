<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$data = explode("\n", $string);

$PAIRS = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];
$illegals = [
    ')' => 0,
    ']' => 0,
    '}' => 0,
    '>' => 0,
];
$cost = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];
foreach ($data as $line) {
    $lineArray = str_split(trim($line));
    $expectedStack = new SplStack();
    foreach ($lineArray as $char) {
        // Si c'est ouvrant
        if (key_exists($char, $PAIRS)) {
            // on ajoute la fermeture à notre stack
            $expectedStack->push($PAIRS[$char]);
        } else {
            $expected = $expectedStack->pop();
            // Si le char est différent de ce qu'on attend (on attend la fermeture de la dernière ouverture ajoutée)
            if ($expected !== $char) {
                // C'est une erreur
                $illegals[$char]++;
                // On quitte la ligne
                break;
            }
        }
    }
}

$sum = 0;
foreach ($illegals as $illegal => $occurence) {
    $sum += $occurence*$cost[$illegal];
}

echo "Sum : $sum\n";

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>