<?php
require_once dirname(__FILE__) . "/PyDict.php";

/**
 * 汉字拼音转换类
 *
 * @author wzy
 *        
 */
class Pinyin
{

    /**
     * 汉字拼音转换程序(支持多音字)
     *
     * @param string $keyword            
     * @return array
     */
    public static function getPinyin ($keyword, $type = null)
    {
        // 变量定义
        $hz = PyDict::$hanzi;
        $result = "";
        
        // 转换成utf-8编码数组
        $utf8_arr = Pinyin::strSplitPhp5Utf8($keyword);
        
        switch ($type) {
            case 1:
                // 获取每个汉字的首字母
                foreach ($utf8_arr as $char) {
                    if (isset($hz[$char])) {
                        $result .= substr($hz[$char][0], 0, 1);
                    } else {
                        $result .= $char;
                    }
                }
                $result = array(
                        $result
                );
                break;
            case 2:
                // 只获取第一个汉字的首字母,非汉字统一为#
                foreach ($utf8_arr as $char) {
                    if (isset($hz[$char])) {
                        foreach ($hz[$char] as $pinyin) {
                            $result[] = substr($pinyin, 0, 1);
                        }
                    } else {
                        $value = ord($char);
                        if ($value >= 65 && $value <= 89 || $value >= 97 && $value <= 122) {
                            $result = strtolower($char);
                        } else {
                            $result = '#';
                        }
                        $result = array(
                                $result
                        );
                    }
                    break;
                }
                break;
            default:
                // 汉字转换成拼音
                foreach ($utf8_arr as $char) {
                    if (isset($hz[$char])) {
                        $result .= $hz[$char][0];
                    } else {
                        $result .= $char;
                    }
                }
                $result = array(
                        $result
                );
                break;
        }
        return $result;
    }

    /**
     * 根据UTF-8编码字节含义将字符串划分成单个UTF-8编码数组
     *
     * @param string $str            
     * @return array $array
     */
    private static function strSplitPhp5Utf8 ($str)
    {
        // 字符串首先转换成utf-8编码
        $str = mb_convert_encoding($str, "utf-8", "auto");
        
        // 根据UTF-8编码字节含义划分成单个编码数组
        $split = 1;
        $array = array();
        for ($i = 0; $i < strlen($str);) {
            $value = ord($str[$i]);
            if ($value > 127) {
                if ($value >= 192 && $value <= 223)
                    $split = 2;
                elseif ($value >= 224 && $value <= 239)
                    $split = 3;
                elseif ($value >= 240 && $value <= 247)
                    $split = 4;
            } else {
                $split = 1;
            }
            $key = "";
            for ($j = 0; $j < $split; $j ++, $i ++) {
                $key .= $str[$i];
            }
            $array[] = $key;
        }
        return $array;
    }
}

?>