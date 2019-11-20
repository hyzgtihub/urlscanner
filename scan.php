<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/19 0019
 * Time: 下午 5:05
 */
//Composer创建的自动加载器其实就是个名为autoload.php的文件，保存在vendor目录中，Composer下载各个PHP组件时，会检查每个组件的composer.json文件，确定如何加载该组件，得到这个信息后，Composer会在本地为该组件创建一个符合PSR标准的自动加载器。这样我们就可以实例化项目中的任何PHP组件，这些组件按需自动加载。
//编写代码
//下面我们正式使用Guzzle和CSV组件编写scan.php代码：
//实例Guzzle Http客户端

require 'vendor/autoload.php';

$client = new GuzzleHttp\Client();
//打开并迭代处理CSV
$csv = League\Csv\Reader::createFromPath($argv[1]);
foreach ($csv as $csvRow) {
    try {
//发送HTTP GET请求
        $httpResponse = $client->get($csvRow[0]);
        //检查HTTP响应的状态码
        if($httpResponse->getStatusCode() >= 400) {
            throw new Exception();
        }
    } catch (Exception $e) {
        //把死链发给标准输出
        echo $csvRow[0] . PHP_EOL;
    }

}

//下面我们在urls.csv中添加一些URL，一行一个，而且至少有一个是死链：
//然后打开终端，执行scan.php脚本：
//php scan.php urls.csv
//我们传入了两个参数，第一个是脚本文件scan.php的路径，另一个是CSV文件的路径。输出如下：
//下一节我们将探讨私有的PHP组件以及如何创建自己的PHP组件并上传到Packagist。