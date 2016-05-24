<?php


require 'vendor/autoload.php';

use app\Controller\ProxyController;


$proxy_model = new \app\Models\Proxy();
$proxy_model->clearProxy();
$proxy = new ProxyController();
$proxy->searchProxy();
$proxy->searchProxy2();
$proxy->searchProxy5();    // парсинг списков прокси
$proxy->searchProxy4();
$proxy->searchProxy6();
$proxy->searchProxy7();

$stream = $argc[1];
$loop = React\EventLoop\Factory::create();
echo $stream;
// Stream 1
/*

$process = new React\ChildProcess\Process('php proxyStream1.php');
$process->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function ($timer) use ($process) {
    $process->start($timer->getLoop());
    $process->stdout->on('data', function ($output) {
        echo "Stream 1 says: {$output}";
    });
});

// Stream 2
$process2 = new React\ChildProcess\Process('php proxyStream2.php');
$process2->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function ($timer) use ($process2) {
    $process2->start($timer->getLoop());
    $process2->stdout->on('data', function ($output) {
        echo "Stream 2 says: {$output}";
    });
});

// Stream 3
$process3 = new React\ChildProcess\Process('php proxyStream3.php');
$process3->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function ($timer) use ($process3) {
    $process3->start($timer->getLoop());
    $process3->stdout->on('data', function ($output) {
        echo "Stream 3 says: {$output}";
    });
});

// Stream 4
$process4 = new React\ChildProcess\Process('php proxyStream4.php');
$process4->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function ($timer) use ($process4) {
    $process4->start($timer->getLoop());
    $process4->stdout->on('data', function ($output) {
        echo "Stream 4 says: {$output}";
    });
});*/

$loop->addPeriodicTimer(5, function ($timer) {
    echo "Parent cannot be blocked by child\n";
});
$loop->run();

/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\parser.php*/

