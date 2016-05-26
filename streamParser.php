<?php
require 'vendor/autoload.php';

$people_model = new \app\Models\People();
$stream = 1;
$j = 1;  // номер потока
if (isset($argv[1])) {
    $stream = $argv[1];
}
if (isset($argv[2])) {
    $j = $argv[2];
}


$people = $people_model->getPeople();

$count = round(count($people) / $stream);

$end = $count;
if ($j <= 0) {
    echo "Error";
} elseif ($j == 1) {
    $start = 0;

} elseif ($j >= 2) {
    $start = $count * ($j - 1);
}

$people = $people_model->getPeopleLimit($start, $end);

$result = $people_model->getResult();
if (empty($result)) {
    $result[0]['user_id'] = 0;
}
//print_r($people);
$people = TwoArray($people, $result); // удаляет имена из массива которые уже сохранены в таблице result

for ($i = 0; $i < count($people); $i++) {

    echo $people[$i]['first'] . " " . $people[$i]['last'] . "\n";

    $p = new \app\Controller\ParserController();

    $p->google($people[$i]['first'], $people[$i]['last'], $people[$i]['id'], $j);
    sleep(2);
}


function TwoArray($arr1, $arr2)
{
    for ($i = 0; $i < count($arr1); $i++) {
        for ($j = 0; $j < count($arr2); $j++) {
            if (isset($arr1[$i]) && isset($arr2[$j])) {
                if ($arr1[$i]['id'] == $arr2[$j]['user_id']) {

                    unset($arr1[$i]);
                    sort($arr1);
                    $i--;
                }
            }
        }
    }
    return $arr1;
}