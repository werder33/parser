<?php

require 'vendor/autoload.php';


$proxy = new \app\Controller\ProxyController();
$proxy -> ProxyAPI(5000);

/*$proxy = new \app\Controller\ProxyController();
$proxy_model = new \app\Models\Proxy();

$server = $proxy_model->getProxy();
// определяем сколько ip на один поток
$count = round(count($server) / $stream);
$end = $count;
if ($i <= 0) {
    echo "Error";
} elseif ($i == 1) {
    $start = 0;

} elseif ($i >= 2) {
    $start = $count * ($i - 1);
}

$server = $proxy_model->getProxyLimit($start, $end);

$proxy->getMultiProxy($server, $i);*/