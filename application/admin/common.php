<?php

/**
 * 将字符解析成数组
 * 
 * @param
 *            $str
 */
function parseParams($str)
{
    $arrParams = [];
    parse_str(html_entity_decode(urldecode($str)), $arrParams);
    return $arrParams;
}

/*
 * 
 * 随机数
 * @random(参数)
 * 
 * 
 * */
function random($len) {
    $chars = array("0", "1", "2","3", "4", "5", "6", "7", "8", "9");
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i=0; $i<$len; $i++){
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}






