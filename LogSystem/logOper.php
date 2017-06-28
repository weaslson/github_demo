<?php
/**
 * Created by PhpStorm.
 * User: Jason·wealson
 * Date: 2017/6/28
 * Time: 10:45
 * 日志读取写入
 *
 */
require_once 'Log.class.php';
$filename = "Logs/log_".date("ymdhis",time()).'.txt';
$msg='写入日志';
$log = new Log();
$log->writeLog($filename,$msg);
$Loglist = $log->readLog($filename);