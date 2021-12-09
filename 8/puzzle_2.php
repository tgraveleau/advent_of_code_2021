<?php
$debut = microtime(true);
$string = include("data.php");
// $string = include("data_test.php");
$data = explode("\n", $string);

$DIGITS_UNIQUE_SIZE = [
    // 0 => 6,
    1 => 2,
    // 2 => 5,
    // 3 => 5,
    4 => 4,
    // 5 => 5,
    // 6 => 6,
    7 => 3,
    8 => 7,
    // 9 => 6,
];

$DIGITS_WIRES = [
    0 => ['a','b','c','e','f','g'],
    1 => ['c','f'],
    2 => ['a','c','d','e','g'],
    3 => ['a','c','d','f','g'],
    4 => ['b','c','d','f'],
    5 => ['a','b','d','f','g'],
    6 => ['a','b','d','e','f','g'],
    7 => ['a','c','f'],
    8 => ['a','b','c','d','e','f','g'],
    9 => ['a','b','c','d','f','g'],
];

$sum = 0;
foreach ($data as $lineBrut) {
    $line = array_map('trim', explode('|',$lineBrut));
    $digits = explode(' ', $line[0]);
    $digitATrouver = explode(' ', $line[1]);
    $otherDigits = $nonUniqueDigits = $mapping = [];
    // Récupère les uniques
    foreach ($digits as $digit) {
        $uniqueDigit = array_search(strlen($digit), $DIGITS_UNIQUE_SIZE);
        if (false !== $uniqueDigit) {
            $mapping[$uniqueDigit] = str_split($digit);
        } else {
            $nonUniqueDigits[] = $digit;
        }
    }
    // Récupère les non uniques
    foreach ($nonUniqueDigits as $digit) {
        $digitArray = str_split($digit);
        // Le 3 c'est 5 segments et il a le 7, le 1 et le 2 compris. On check que le 7 car les autres 5 segments ne l'ont pas de compris
        if (5 == count($digitArray) && checkDigitIsInDigit($digitArray, $mapping[7])) {
            $mapping[3] = $digitArray;
            $tmp = array_diff($nonUniqueDigits, [$digit]);
            foreach ($tmp as $chercheNeuf) {
                $chercheNeufArray = str_split($chercheNeuf);
                // Le 9 c'est 6 segments et il a le 3
                if (6 == count($chercheNeufArray) && checkDigitIsInDigit($chercheNeufArray, $mapping[3])) {
                    $mapping[9] = $chercheNeufArray;
                    // on chope le b en faisant la diff entre le 9 et le 3
                    $currentB = array_values(array_diff($chercheNeufArray,$digitArray))[0];
                    $tmp2 = array_diff($tmp, [$chercheNeuf]);
                    foreach ($tmp2 as $chercheCinq) {
                        $chercheCinqArray = str_split($chercheCinq);
                        // Le 5 c'est 5 segments avec le b
                        if (5 == count($chercheCinqArray) && in_array($currentB, $chercheCinqArray)) {
                            $mapping[5] = $chercheCinqArray;
                            $tmp3 = array_diff($tmp2, [$chercheCinq]);
                            foreach ($tmp3 as $lereste) {
                                $leresteArray = str_split($lereste);
                                $nbSegment = count($leresteArray);
                                // Le seul à cinq qui reste c'est le 2
                                if (5 == $nbSegment) {
                                    $mapping[2] = $leresteArray;
                                }
                                // Il reste 2 à 6
                                elseif (6 == $nbSegment) {
                                    // S'il a le 1, c'est le 0
                                    if (checkDigitIsInDigit($leresteArray,$mapping[1])) {
                                        $mapping[0] = $leresteArray;
                                    }
                                    // sinon c'est le 6
                                    else {
                                        $mapping[6] = $leresteArray;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    $code = "";
    foreach ($digitATrouver as $d) {
        foreach ($mapping as $number => $segments) {
            $dArray = str_split($d);
            if (identical_values($dArray, $segments)) {
                $code .= $number;
            }
        }
    }
    $sum += intval($code);
}

echo "Sum : $sum\n";

function checkDigitIsInDigit($digit1, $digit2) {
    foreach ($digit2 as $d2) {
        if (!in_array($d2,$digit1)) {
            return false;
        }
    }
    return true;
}

function identical_values( $arrayA , $arrayB ) {
    sort( $arrayA );
    sort( $arrayB );
    return $arrayA == $arrayB;
}

$end = microtime(true);
echo "Durée : ".($end-$debut)." sec\n";
?>