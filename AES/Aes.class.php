<?php

/**
 * Created by PhpStorm.
 * User: Jason·wealson
 * Date: 2017/6/28
 * Time: 9:26
 * desc:使用aes数据加密算法进行数据的加密和解密，先确保php的环境中安装好了Mcrypt扩展
 * 常用函数汇总：
 * mcrypt_module_open():打开mcrypt资源对象
 * CONST MCRYPT_MODE_ECB：加密模型：适合小数量随机数据的加密。比如用户的登陆密码
 *mcrypt_create_iv()：创建iv(初始化向量)
 * mcrypt_generic_init()：根据密钥和vi初始化,完成内存分配等初始化工作。
 * mcrypt_generic_deinit()：反初始化，释放资源
 * mcrypt_module_close():关闭资源对象，退出
 * ord():返回字符串首个字母的ASCII值。
 *chr()：返回ASCII值对于的字符
 * hexdec():把十六进制转换为十进制
 */
class Aes
{
    private $secrect_key;

    public function __construct($secrect_key)
    {
        $this->secrect_key = $secrect_key;
    }

    //加密
    public function encrypt($str)
    {
        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'',MCRYPT_MODE_ECB,'');
        $iv = $this->createIv($cipher);
        if (mcrypt_generic_init($cipher,$this->pad2Length($this->secrect_key,16),$iv) != -1){
            $cipherText = mcrypt_generic($cipher,$this->pad2Length($str,16));
            mcrypt_generic_deinit($cipher);
            mcrypt_module_close($cipher);

            return bin2hex($cipherText);
        }
    }

    // 解密
    public function decrypt($str)
    {
        $padKey = $this->pad2Length($this->secrect_key,16);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'',MCRYPT_MODE_ECB,'');
        $iv = $this->createIv($td);
        if(mcrypt_generic_init($td,$padKey,$iv) != -1){
            $p_t = mdecrypt_generic($td,$this->hexToStr($str));
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);

            return $this->trimEnd($p_t);
        }
    }

    //iv自动生成
    private function createIv($td)
    {
        $iv_size = mcrypt_enc_get_iv_size($td);
        $iv = mcrypt_create_iv($iv_size,MCRYPT_RAND);
        return $iv;
    }

    //将$text 补足$padlen倍数的长度
    private function pad2Length($text,$padlen)
    {
        $len = strlen($text)%$padlen;
        $res = $text;
        $span = $padlen-$len;
        for ($i=0;$i<$span;$i++){
            $res .= chr($span);
        }
        return $res;
    }
    //将解密后多余的长度去掉（因为在加密时补充长度满足block_size 的长度）
    private function trimEnd($text)
    {
        $len = strlen($text);
        $c = $text[$len-1];
        if (ord($c) <$len){
            for ($i=$len-ord($c); $i<$len;$i++){
                if ($text[$i] != $c){
                    return $text;
                }
            }
            return substr($text,0,$len-ord($c));
        }
        return $text;
    }

    //16进制转换成2进制字符串
    private function hexToStr($hex)
    {
        $bin ="";
        for ($i=0;$i<strlen($hex)-1;$i+=2){
            $bin .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $bin;
    }
}