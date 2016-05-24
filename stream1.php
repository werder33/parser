<?php
require 'vendor/autoload.php';

$parser = new \app\Controller\ParserController();


$people_model = new \app\Models\People();
$proxy = new \app\Controller\ParserController();
$i = 0;
$people = $people_model->getPeopleLimit(0, 264);

for ($i = 0; $i < count($people); $i++) {

    echo $people[$i]['first'] . " " . $people[$i]['last'] . "\n";

    $p = new \app\Controller\ParserController();

    $p->google($people[$i]['first'], $people[$i]['last'], $people[$i]['id']);
    sleep(2);
}


