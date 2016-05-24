<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:42
 */

namespace app\Controller;

use app\Models\People;
use app\Models\Proxy;


class ParserController extends Controller
{

    public function __construct()
    {

    }

    public function google($name, $surname, $user_id = null)
    {

        $url = 'http://www.google.com/search?num=20&q=' . $name . '+' . $surname;
        $content = $this->getContent($url);
        if (empty($content)) {
            echo "<<<<====== END PROXY ======>>>>";
        } else {
            $pars_array = [];
            $pars_array['title'] = $this->getTitle($content);
            $pars_array['url'] = $this->getUrl($content);
            $pars_array['snippet'] = $this->getSnippet($content);

            $pars_array = $this->checkParsing($pars_array, $name);
            for ($i = 0; $i < count($pars_array); $i++) {
                $m = new People();
                $m->saveResult($pars_array[$i], $user_id);
            }
        }
    }


    public function getTitle($content)
    {
        $arr = [];
        $i = 0;
        $html = str_get_html($content);
        if (count($html->find('.r'))) {
            foreach ($html->find('.r > a') as $div) {
                $arr[$i] = strip_tags($div->innertext);
                $i++;
            }
        }
        return $arr;
    }


    public function getUrl($content)
    {
        $arr = [];
        $i = 0;
        $html = str_get_html($content);
        if (count($html->find('cite'))) {
            foreach ($html->find('cite') as $div) {
                $arr[$i] = $div->plaintext;
                $i++;
            }
        }
        return $arr;
    }


    public function getSnippet($content)
    {
        $arr = [];
        $i = 0;
        $html = str_get_html($content);
        if (count($html->find('.st'))) {
            foreach ($html->find('.st') as $div) {
                $arr[$i] = strip_tags($div->innertext);
                $i++;
            }
        }
        return $arr;
    }


    public function getContent($url)
    {
        $proxy_model = new Proxy();
        $proxies = $proxy_model->getGoodProxy();
        if (empty($proxies)) {
            echo "<<<<======= PROXY NOT FOUND =======>>>>>>\n";
            exit();
        }

        $steps = count($proxies);
        $step = 0;
        $try = true;

        while ($try) {
            $proxy = isset($proxies[$step]['ip']) ? $proxies[$step]['ip'] : null;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            //  @curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            $out = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            echo $proxy . " - " . $http_code . "\n";
            $step++;
            if ($http_code == 404) {
                echo "<<<<<<<<<<<====== PAGE NOT FOUND =======>>>>>>>>>\n";
            }
            $try = (($step < $steps) && $http_code != 200 && $http_code != 404);
        }

        return $out;
    }


    public function checkParsing($arr, $name)
    {
        $checkArray = [];
        $j = 0;
        for ($i = 0; $i < count($arr['title']); $i++) {
            if (strpos($arr['title'][$i], $name) !== false || strpos($arr['snippet'][$i], $name) !== false) {
                $checkArray[$j]['title'] = $arr['title'][$i];
                $checkArray[$j]['snippet'] = $arr['snippet'][$i];
                $checkArray[$j]['url'] = $arr['url'][$i];
                $j++;
            }
        }
        print_r($checkArray);
        return $checkArray;
    }
}