<?php
/**
 * Description:拼音转换类测试程序
 */
require_once dirname(__FILE__) . "/Pinyin.php";

$keyword = "黄老师很犀利，number1";
$str = Pinyin::getPinyin($keyword);
echo $str;
