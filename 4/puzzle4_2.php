<?php
$string = include("data.php");
$data = explode('

', $string);
$nbtotal = count($data);

$NB_COLUMN = 5;
//var_dump($data);

$tirage = array_map('intval', explode(',', $data[0]));
$boards = [];

// Initialisation des boards
for ($i=1; $i<$nbtotal; $i++) {
    $numbers = preg_split('/[\s]+/', $data[$i]);
    $board = [];
    $line = [];
    $counter = 0;
    foreach ($numbers as $n) {
        $line[] = [
            'number' => intval($n),
            'marked' => false,
        ];
        $counter++;
        if ($counter % $NB_COLUMN == 0) {
            $board[] = $line;
            $line = [];
            $counter = 0;
        }
    }
    $boards[] = $board;
}

// LOTO
$nbBoard = count($boards);
$res = null;
$winningBoards = [];
foreach ($tirage as $n) {
    echo "n : $n\n";
    foreach ($boards as $indexBoard => $board) {
        $nbLine = count($boards[$indexBoard]);
        // echo "board : $indexBoard\n";
        for ($i=0; $i<$nbLine; $i++) {
            // echo "ligne : $i\n";
            for ($j=0; $j<$NB_COLUMN; $j++) {
                // echo "colonne : $j\n";
                if ($boards[$indexBoard][$i][$j]['number'] == $n) {
                    // echo "number : ".$boards[$indexBoard][$i][$j]['number']." marked\n";
                    $boards[$indexBoard][$i][$j]['marked'] = true;
                }
            }
        }
        if (check($boards[$indexBoard], $NB_COLUMN)) {
            if (!array_key_exists($indexBoard, $winningBoards)) {
                $winningBoards[$indexBoard] = $n;
                echo "Board ".($indexBoard+1)." win with $n\n";
            } else {
                echo "Board ".($indexBoard+1)." already won\n";
            }
            if (count($winningBoards) == $nbBoard) {
                $res = [
                    'board' => $boards[$indexBoard],
                    'number' => $n,
                ];
                break;
            }
        }
    }
    if (null !== $res) {
        break;
    }
}

if (null === $res) {
    if (count($winningBoards) > 0) {
        echo array_key_last($winningBoards)." : ".end($winningBoards)."\n";
        $res = [
            'board' => $boards[array_key_last($winningBoards)],
            'number' => end($winningBoards),
        ];
    } else {
        echo "RIEN\n";
        exit;
    }
}
$win = $res['board'];

$sum = 0;
foreach ($win as $line) {
    foreach ($line as $el) {
        if (!$el['marked']) {
            $sum += $el['number'];
        }
    }
}

//var_dump($win);
echo "sum : $sum, n : ".$res['number'].", res = ".$sum*$res['number']."\n";

/**
 * ===========
 * FUNCTIONS
 * ===========
 */

function check($board, $nbcolumn) {
    // ligne
    foreach ($board as $line) {
        $ok = true;
        foreach ($line as $el) {
            if (!$el['marked']) {
                $ok = false;
                break;
            }
        }
        if ($ok) {
            echo "ligne\n";
            return true;
        }
    }
    // colonne
    for ($i=0; $i<$nbcolumn; $i++) {
        $ok = true;
        foreach ($board as $line) {
            if (!$line[$i]['marked']) {
                $ok = false;
                break;
            }
        }
        if ($ok) {
            echo "colonne\n";
            return true;
        }
    }
    return false;
}
?>