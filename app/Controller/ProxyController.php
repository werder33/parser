<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 19:01
 */

namespace app\Controller;


use app\Models\People;

class ProxyController
{
    public function test(){
       /* $model = new People();
        $m = $model->getPeople();
        echo($m[29]['first']);*/
			echo "My site";
    }


    public function searchProxy()
    {
        $path = "http://webanetlabs.net/publ/9-1-0-15";

        $page = file_get_contents($path);
        $pattern = '|\n[\d.:]+|';
        preg_match_all($pattern, $page, $out);

        // удаляем старые записи из файла
        $fo = fopen("file/proxy.txt", "w");
        fclose($fo);

        //записываем новые данные
        file_put_contents('file/proxy.txt',$out[0], FILE_APPEND);

    }


    public function checkProxy(){
        //$host = "http://site.com";
       // $this->searchProxy();
        $path = "file/proxy.txt";
        $fo = fopen("file/coolProxy.txt", "w");
        fclose($fo);

        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 65000);
        $proxy_server = explode("\n", $proxy);

        for ($i = 0; $i <= count($proxy_server) - 1; $i++) {
            $proxy_serv[$i] = explode(":", $proxy_server[$i]);
        }
        fclose($f_proxy);

        for ($i = 0; $i < count($proxy_serv); $i++) {
            //echo $proxy_serv[$i][0];
            $fp = @fsockopen($proxy_serv[$i][0], $proxy_serv[$i][1], $errno, $errstr, 0.5);
            if (!$fp)
            {
             echo $i." Error <br />";
            }
            else{
                file_put_contents('file/coolProxy.txt', $proxy_serv[$i][0].":".$proxy_serv[$i][1]."\n",FILE_APPEND);
                echo $i." ok <br />";
            }
        }

    }



}