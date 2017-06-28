<?php

/**
 * Created by PhpStorm.
 * User: Jason·wealson
 * Date: 2017/6/28
 * Time: 10:33
 * php 日志类 记录和读取json格式的日志文件
 */
class Log
{
    private $maxSize = 1024000 ;//最大日志文件大小为1M

    //写入日志
    public function writeLog($filename,$msg)
    {
        $res = array();
        $res['msg'] = $msg;
        $res['logtime'] = date("Y-m-d H:i:s",time());

        //如果日志文件超过了指定的大小则备份日志文件
        if (file_exists($filename) && abs(filesize($filename)) > $this->maxSize){
            $newfilename = dirname($filename) . '/' . time() .'-'.basename($filename);
            rename($filename,$newfilename);
        }

        //如果是新建日志文件，则去掉内容中的第一个字符逗号
        if (file_exists($filename) && abs(filesize($filename)) > 0){
            $content = "," .json_encode($res);
        }else{
            $content = json_encode($res);
        }
        //往日志后面追加日志内容
        file_put_contents($filename,$content,FILE_APPEND); //以追加的方式添加日志文件
    }

    //读取日志

    public function readLog($filename)
    {
        if (file_exists($filename)){
            $content = file_get_contents($filename);
            $json = json_decode('['.$content.']',true);
        }else{
            $json = '{"msg":"the log file does not exists"}';
        }
        return $json;
    }

}