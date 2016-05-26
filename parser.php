<?php


require 'vendor/autoload.php';
$stream = 1;
if (isset($argv[1])) {
    $stream = $argv[1];
}

$loop = React\EventLoop\Factory::create();
$proxy = new \app\Controller\ProxyController();
$proxyModel = new \app\Models\Proxy();

$proxyModel->clearProxy();
$proxy->proxyAPI(200);

for ($i = 1; $i <= $stream; $i++) {
    $process = new React\ChildProcess\Process('php streamParser.php ' . $stream . ' ' . $i);
    $process->on('exit', function ($exitCode, $termSignal) {
        echo "Child exit\n";
    });
    $loop->addTimer(0.501, function ($timer) use ($process) {
        $process->start($timer->getLoop());
        $process->stdout->on('data', function ($output) {
            echo "{$output}";
        });
    });
    sleep(1);
}
$process = new React\ChildProcess\Process('php stream.php ');
$process->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.501, function ($timer) use ($process) {
    $process->start($timer->getLoop());
    $process->stdout->on('data', function ($output) {
        echo "{$output}";
    });
});
$loop->addPeriodicTimer(5, function ($timer) {
    echo "Parent cannot be blocked by child\n";
});
$loop->run();

/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\parser.php*/

