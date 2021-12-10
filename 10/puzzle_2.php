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
$scoreValues = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
];

$scores = [];
foreach ($data as $line) {
    $lineArray = str_split(trim($line));
    $err = false;
    $expectedStack = new SplStack();
    foreach ($lineArray as $char) {
        // Si c'est ouvrant
        if (key_exists($char, $PAIRS)) {
            // on ajoute la fermeture à notre stack
            $expectedStack->push($PAIRS[$char]);
        }
        // Sinon, on s'attend à ce que ce soit le dernier fermant qu'on a ajouté
        else {
            $expected = $expectedStack->pop();
            // Si le char est différent de ce qu'on attend
            if ($expected !== $char) {
                // On quitte la ligne avec une erreur
                $err = true;
                break;
            }
        }
    }
    // Si on a fini la ligne sans erreur et qu'il nous reste des choses dans la stack, on la dépile pour compléter
    if (!$err && !$expectedStack->isEmpty()) {
        $score = 0;
        while (!$expectedStack->isEmpty()) {
            $next = $expectedStack->pop();
            $score = 5*$score + $scoreValues[$next];
        }
        $scores[] = $score;
    }
}

sort($scores);
$middleIndex = intdiv(count($scores),2);
echo "Middle value : ".$scores[$middleIndex]."\n";

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>