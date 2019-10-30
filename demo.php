<?php

// An example of using php-webdriver.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;

use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

 

//chromedriver默认端口

$host = 'http://localhost:9515';

 

$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 50000);

$driver->get('http://www.baidu.com');

 

$cookies = $driver->manage()->getCookies();

print_r($cookies);

 

 

echo "The title is '" . $driver->getTitle() . "'\n";

echo "The current URI is '" . $driver->getCurrentURL() . "'\n";

 

//关闭浏览器

$driver->quit();