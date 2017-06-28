<?php
/**
 * Created by PhpStorm.
 * User: Jason·wealson
 * Date: 2017/6/28
 * Time: 11:37
 * 生成会员卡号
 */
require_once 'Code.class.php';
$code = new Code();
$card_no = $code->encodeID(888888,5);
$card_pre = '755';
$card_vc = substr(md5($card_pre.$card_no),0,2);
$card_vc = strtoupper($card_vc);
echo $card_pre.$card_no.$card_vc;