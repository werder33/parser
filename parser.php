<?php


require 'vendor/autoload.php';


$loop = React\EventLoop\Factory::create();
// Stream 1
$process = new React\ChildProcess\Process('php stream1.php');
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
$process2 = new React\ChildProcess\Process('php stream2.php');
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
$process3 = new React\ChildProcess\Process('php stream3.php');
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
$process4 = new React\ChildProcess\Process('php stream4.php');
$process4->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function ($timer) use ($process4) {
    $process4->start($timer->getLoop());
    $process4->stdout->on('data', function ($output) {
        echo "Stream 4 says: {$output}";
    });
});

$loop->addPeriodicTimer(5, function ($timer) {
    echo "Parent cannot be blocked by child\n";
});
$loop->run();

/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\parser.php*/

