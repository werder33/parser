<?php


require 'vendor/autoload.php';
$stream = 1;
if (isset($argv[1])) {
    $stream = $argv[1];
}
$start = 0;
$loop = React\EventLoop\Factory::create();
$proxy = new \app\Controller\ProxyController();
$proxyModel = new \app\Models\Proxy();

//$proxyModel->clearProxy();
//$proxy->proxyAPI(100);

    for ($i = 1; $i <= $stream; $i++) {
        $process = new React\ChildProcess\Process('php streamParser.php ' . $stream . ' ' . $i . ' ' . $start);
        $process->on('exit', function ($exitCode, $termSignal) {
            echo "Child exit\n";
        });
        $loop->addTimer(0.501, function ($timer) use ($process) {
            $process->start($timer->getLoop());
            $process->stdout->on('data', function ($output) {
                echo "{$output}";
            });
        });
        $start = $start+10;
    }

/*$process = new React\ChildProcess\Process('php stream.php ');
$process->on('exit', function ($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.501, function ($timer) use ($process) {
    $process->start($timer->getLoop());
    $process->stdout->on('data', function ($output) {
        echo "{$output}";
    });
});*/
$loop->addPeriodicTimer(5, function ($timer) {
    echo "Parent cannot be blocked by child\n";
});
$loop->run();

/*C:\OpenServer\modules\php\PHP-5.6\php C:\OpenServer\domains\parser\src\parser.php*/

