<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 19:01
 */

namespace app\Controller;


use app\Models\People;
use app\Models\Proxy;


class ProxyController extends Controller
{
    protected $proxyModel;

    public function __construct()
    {
        $this->proxyModel = new Proxy();
    }

    public function searchProxy()
    {
        $this->proxyModel->clearProxy();  // Удаляем все записи

        $path = "http://webanetlabs.net/publ/9-1-0-15";
        $page = file_get_contents($path);
        $pattern = '|\n[\d.:]+|';
        preg_match_all($pattern, $page, $out);

        $this->proxyModel->saveProxy($out[0]);

    }

    public function searchProxy2()
    {
        $url = "https://incloak.com/proxy-list/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
        $out = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        $i = 0;
        $arr1 = [];
        $html = str_get_html($out);
        if (count($html->find('tr'))) {

            foreach ($html->find('tr') as $div) {
                $arr1[$i] = strip_tags($div->find('td', 0) . ":" . $div->find('td', 1));
                $i++;
            }
        }
        unset($arr1[0]);
        $this->proxyModel->saveProxy($arr1);

    }


    public function searchProxy3()
    {
        $url = "http://ab57.ru/downloads/proxylist.txt";
        $page = file_get_contents($url);
        $arr = preg_split('/\n/', $page);

        $this->proxyModel->saveProxy($arr);
    }

    public function searchProxy4()
    {
        $url = "http://fineproxy.org/freshproxy/#more-6";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
        $out = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        $i = 0;
        $arr1 = [];
        $html = str_get_html($out);

        if (count($html->find('.storycontent > p'))) {
            foreach ($html->find('.storycontent > p') as $div) {
                $arr1[$i] = $div->innertext;
                $i++;
            }
            preg_match_all('/[\d*\.:]*/', $arr1[0], $out);
        }
        $j = 0;
        for ($i = 100; $i < count($out[0]); $i++) {
            if (!empty($out[0][$i]) && strlen($out[0][$i] >= 15)) {
                $arr1[$j] = $out[0][$i];
                $j++;
            }
        }

        $this->proxyModel->saveProxy($arr1);
    }

    public function searchProxy5()
    {
        $url = "https://www.us-proxy.org/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
        $out = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        $i = 0;
        $arr1 = [];
        $html = str_get_html($out);
        if (count($html->find('tr'))) {

            foreach ($html->find('tr') as $div) {
                $arr1[$i] = strip_tags($div->find('td', 0) . ":" . $div->find('td', 1));
                $i++;
            }
        }
        unset($arr1[count($arr1) - 1]);
        unset($arr1[0]);

        $this->proxyModel->saveProxy($arr1);
    }


    public function searchProxy6()
    {
        $url = "http://www.socks24.org/2016/05/20-05-16-vip-socks-5_70.html";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
        $out = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        $i = 0;
        $arr1 = [];
        $html = str_get_html($out);
        if (count($html->find('span'))) {

            foreach ($html->find('span') as $div) {
                $arr1[$i] = $div->innertext;
                $i++;
            }
        }
        $arr = explode(' ', $arr1[11]);
        unset($arr[count($arr) - 1]);
        $this->proxyModel->saveProxy($arr);
    }

    public function searchProxy7()
    {
        $url = "http://www.idcloak.com/proxylist/free-proxy-ip-list.html";
        $page = file_get_contents($url);
        $pattern = '/(<td>\d*<\/td>)(<td>\d*.\d*.\d*.\d*)?<\/td>/';
        preg_match_all($pattern, $page, $out);
        for ($i = 0; $i < count($out[1]); $i++) {
            $arr1[$i] = strip_tags($out[2][$i] . ":" . $out[1][$i]);
        }
        // print_r($arr1);
        $this->proxyModel->saveProxy($arr1);
    }

    public function searchProxy8()
    {
        $url = "http://free-pass.ru/forum/79-7962-1";
        $page = file_get_contents($url);
        $pattern = '/\d*\.\d*.\d*.\d*:\d*/';
        preg_match_all($pattern, $page, $out);
        $this->proxyModel->saveProxy($out[0]);
    }

    public function getProxy()
    {
        /* $path = "file/proxy.txt";

         $fProxy = fopen($path, 'r');
         $proxy = fread($fProxy, 65000);
         $proxyServer = explode("\n", $proxy);*/

        echo "CHECK PROXY \n";
        $proxyServer = $this->proxyModel->getProxy();
        $url = 'https://www.google.com.ua/';
        $userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
        $timeout = 3;


        for ($i = 0; $i < count($proxyServer); $i++) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_PROXY, trim($proxyServer[$i]['ip']));
            $data = curl_exec($ch);

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            echo $proxyServer[$i]['ip'] . " - " . $httpCode . "\n";
            if ($httpCode == 200) {
                $this->proxyModel->updateProxy($proxyServer[$i]['id']);
            }
            curl_close($ch);
        }
    }

    public function getMultiProxy($proxyServer = [], $stream)
    {
        echo "CHECK PROXY \n";

        $url = 'https://www.google.com.ua/';
        $userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
        $timeout = 3;

        for ($i = 0; $i < count($proxyServer); $i++) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_PROXY, $proxyServer[$i]['ip']);
            $data = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            echo "Stream " . $stream . " - " . $proxyServer[$i]['ip'] . " - " . $httpCode . "\n";
            if ($httpCode == 200) {
                $this->proxyModel->updateProxy($proxyServer[$i]['id']);
            }
            curl_close($ch);
        }
    }

    public function proxyAPI($count)
    {
        // $this->proxy_model->clearProxy();

        for ($i = 0; $i < $count; $i++) {
            $url = "http://gimmeproxy.com/api/getProxy?supportsHttps=false";
            $page = file_get_contents($url);
            //  echo $page;
            //  exit();
            if (isset($page)) {
                $page = json_decode($page);
                $proxy = $page->ipPort;
                echo $proxy . "\n";
                $this->proxyModel->saveOneProxy($proxy);
            }
            sleep(40);
        }
    }


}

