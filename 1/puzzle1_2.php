<?php
$data = include("data.php");
$nbtotal = count($data);

$previous = null;
$counter = 0;

foreach ($data as $i => $d) {
    if ($i > 1) {
        $current = $data[$i] + $data[$i-1] + $data[$i-2];
        if (null === $previous) {
            $previous = $current;
        } else {
            if ($current > $previous) {
                $counter++;
            }
            if ($i < 50) {
                echo "i = $i, current = $current, previous = $previous, counter = $counter\n";
            }
            $previous = $current;
        }
    }
}

echo $counter."\n";

?>