<?php
/**
 * 拼音转换类测试程序
 */
require_once dirname(__FILE__) . "/Pinyin.php";

// 确定换行符
$s_br = (php_sapi_name() == "cli") ? "\n" : "<br>";

// 测试汉字转拼音
$keyword = "黄老师1232很dsdf犀利，number1";
$str = Pinyin::getPinyin($keyword);
echo $str . $s_br;

// 测试获取汉字首字母
$keyword = "好联系";
$str = Pinyin::getPinyin($keyword, 1);
echo $str . $s_br;
