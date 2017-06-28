<?php
/**
 * Created by PhpStorm.
 * User: Jason·wealson
 * Date: 2017/6/28
 * Time: 10:09
 */
require_once 'Aes.class.php';
$key ="MYgGnQE2jDFADSFFDSEWsdD2";
$str ='abc';//需要加密的字符串
$aes = new Aes($key);

//加密
echo $aes->encrypt($str);

//解密
echo $aes->decrypt($str);