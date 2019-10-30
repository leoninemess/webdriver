<?php
namespace app\index\controller;
use Workerman\Worker;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

//require_once("");
class Index
{

    public static $driver;

    public function index(){
        $woker = new Worker("http://0.0.0.0:1993");
        $woker->count =4;
        $woker->onConnect = function (){
            echo "onConnect";
        };
        $woker ->onMessage = function ($con,$data){
            var_dump($data['post']);
            $data = $data['post'];
            if($data['type']=='cd'){
                $res = $this->chadang($data);
                $con->send($res);
            }
        };
        Worker::runAll();
    }

    /**使用单例防止打开过多窗口
     * @param $data
     * @return string
     * @api
     * @author leo
     * @date-time 2019/10/29-15:05
     */
    public function chadang($data){
        $host = 'http://localhost:9515';
        if(self::$driver){
            $driver = self::$driver;
        }else{
            self::$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 50000);
            $driver = self::$driver;
        }
        $url = "https://www.baidu.com/baidu?word=".$data['question'];
        $driver->get($url);
        //根据id获取元素，并赋值。
        $driver->findElement(WebDriverBy::id("kw"))->clear()->sendKeys(123);
        //点击事件
        $driver->findElements(WebDriverBy::tagName("input"))->findElement(WebDriverBy::id('su'))->click();

 //       $driver->executeScript('alert(1)');
        $cookies = $driver->manage()->getCookies();
//        print_r($cookies);
//        echo "The title is '" . $driver->getTitle() . "'\n";
//        echo "The current URI is '" . $driver->getCurrentURL() . "'\n";
        return $driver->getTitle();
        //关闭浏览器
        //$driver->quit();
    }
}
