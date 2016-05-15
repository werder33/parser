<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:42
 */

namespace app\Controller;


class ParserController
{
    public $name;
    public $surname;
    protected $url;
    protected  $content;

    public function __construct()
    {
        //  $this->name = $_POST['name'];
        //  $this->surname = $_POST['surname'];
        $this->name = "Jessica";
        $this->surname = "Alba";


    }

    public function postIndex()
    {

        //$arrUrl = $this->googleParse();

        // $t = $this->siteParse($arrUrl[0]);


    }

    public function googleParse()
    {

       $this->content = $this->getContent();
       // echo $this->content;
      // $t = $this->getTitle();
     //  $url = $this->getUrl();
        $snippet = $this->getSnippet();
       // print_r($url);
      /*  for($i=0; $i<count($t); $i++){
            echo $t[$i]."-=-".$url[$i]."<br />";
        }*/
       // echo $page;
        //file_put_contents('file/page.txt', $this->content);


        //   $path = 'http://www.google.com/search?q=' . $this->name . '+' . $this->surname;
        //echo $path;
        //   $page = file_get_contents($path);
        //   $page = iconv('windows-1251', 'utf-8', $page);
        //  echo $page;


        /* */


        //echo $out[0][4];
        /*   $page = iconv('windows-1251', 'utf-8', $page);
           $pattern = '/q=htt\w{1,2}:\/\/.+?&/';
           preg_match_all($pattern, $page, $out);
           $arr = [];
           for ($i = 0; $i < count($out[0]); $i++) {
               $arr[$i] = $out[0][$i];
               $arr[$i] = $this->mySub($arr[$i]);
           }
           return $arr;*/
    }

    public function getTitle()
    {
        $f = fopen('file/page.txt', 'r');
        $file = fread($f, 65000);

        $arr = [];

        $pattern = '|<h3 class="r"><a[^>]+>(.+?)</a><\/h3>|iu';
        preg_match_all($pattern, $file, $out);
        for($i=0; $i<count($out[1]); $i++){
            $arr[$i] = strip_tags($out[1][$i]);
        }
        return $arr;
    }



    public function getUrl()
    {
        //$f = fopen($this->content, 'r');
        //$file = fread($f, 6500000);
        $arr = [];
        $pattern = '|<h3 class="r"><a href="/url\?q=(.*?)?>|';
        preg_match_all($pattern, $this->content, $out);
        //print_r($out[1]);
       for($i=0; $i<count($out[1]); $i++){
            echo $out[1][$i]."<br />";
        }
       // return $arr;
    }

    public function getSnippet()
    {
        $arr = [];
        $pattern = '/<span class="st">[\S\s]*?<\/span>/';
        preg_match_all($pattern, $this->content, $out);
        //print_r($out);
        for($i=0; $i<count($out[0]); $i++){
            echo $out[0][$i]."<br /><hr />";
        }
    }

    public function mySub($string)
    {
        $string = substr($string, 2);
        $string = substr($string, 0, -1);
        return $string;
    }

    public function getContent()
    {
        // $this->url = "http://www.gibdd.ru/";
        $this->url = 'http://www.google.com/search?q=' . $this->name . '+' . $this->surname;
        //  $this->url = 'http://www.google.com.ua/?gfe_rd=cr&ei=3VU0V8vTJMG9wAPVqIHgCA#q=hj+jlk';


        $path = 'file/coolProxy.txt';
        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 65000);
        $proxies = explode("\n", $proxy);
        $steps = count($proxies);
        $step = 0;
        $try = true;
        //$arr =[];
       // while ($try) {
            $proxy = isset($proxies[$step]) ? $proxies[$step] : null;

            //$proxy = $proxies[140];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
           // curl_setopt($ch, CURLOPT_PROXY, $proxy);
            //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
            $out = curl_exec($ch);
            // $out = iconv('CP1251', 'UTF-8', curl_exec($ch));
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            echo $error;
            curl_close($ch);
            //$arr[$step]=$http_code;
            // echo $http_code;
            $step++;
            $try = (($step < $steps) && $http_code != 200);
      //  }
        return $out;
    }
}