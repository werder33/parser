<?php
require 'vendor/autoload.php';

$peopleModel = new \app\Models\People();
$stream = 1;
$j = 1;  // номер потока
$start = 0;
if (isset($argv[1])) {
    $stream = $argv[1];
}
if (isset($argv[2])) {
    $j = $argv[2];
}
if (isset($argv[3])) {
    $start = $argv[3];
}

$try = true;
while ($try) {
    $people = $peopleModel->getPeopleLimit($start, 10);
    for ($i = 0; $i < count($people); $i++) {
        echo "Stream " . $j . " - " . $start;
        echo $people[$i]['first'] . " " . $people[$i]['last'] . "\n";
        $p = new \app\Controller\ParserController();
        $p->google($people[$i]['first'], $people[$i]['last'], $people[$i]['id'], $j);

    }
    $try = (count($people) > 0);
}



