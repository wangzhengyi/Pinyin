<?php
require_once dirname(__FILE__) . "/PyTable.php";

/**
 * Description:汉字拼音转换类
 *
 * @author wzy
 *        
 */
class Pinyin
{

    /**
     * Description:汉字拼音转换程序
     *
     * @param string $keyword            
     * @return Ambigous <string, unknown>
     */
    public static function getPinyin ($keyword, $type = null)
    {
        // 变量定义
        $hz = PyTable::$hz;
        $result = "";
        
        // 转换成utf-8编码数组
        $utf8_arr = Pinyin::strSplitPhp5Utf8($keyword);
        
        switch ($type) {
            case 1:
                // 获取汉字首字母
                foreach ($utf8_arr as $char) {
                    if (isset($hz[$char])) {
                        $result .= substr($hz[$char], 0, 1);
                    } else {
                        $result .= $char;
                    }
                }
                break;
            default:
                // 汉字转换成拼音
                foreach ($utf8_arr as $char) {
                    if (isset($hz[$char])) {
                        $result .= $hz[$char];
                    } else {
                        $result .= $char;
                    }
                }
        }
        
        return $result;
    }

    /**
     * Description:根据UTF-8编码字节含义将字符串划分成单个UTF-8编码数组
     *
     * @param string $str            
     * @return multitype:
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
