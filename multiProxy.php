<?php


require 'vendor/autoload.php';

use app\Controller\ProxyController;


$proxy_model = new \app\Models\Proxy();
/*$proxy_model->clearProxy();
$proxy = new ProxyController();
$proxy->searchProxy();
$proxy->searchProxy2();
$proxy->searchProxy5();    // парсинг списков прокси
$proxy->searchProxy4();
$proxy->searchProxy6();
$proxy->searchProxy7();*/

$stream = 1;
if (isset($argv[1])) {
    $stream = $argv[1];
}


$loop = React\EventLoop\Factory::create();

for($i=1; $i<=$stream; $i++){
    $process = new React\ChildProcess\Process('php streamProxy.php '. $stream.' '.$i);
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

$loop->addPeriodicTimer(5, function ($timer) {
    echo "Parent cannot be blocked by child\n";
});
$loop->run();

/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\parser.php*/

