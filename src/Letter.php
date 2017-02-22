<?php

/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 11:54
 */
class Letter
{
    /**
     * @param $strng
     * @return array
     */
    public static function str_split_utf8($strng, $isLowerCase = false)
    {
        $split = 1;
        $listsChars = [];
        for ($i = 0; $i < strlen($strng);) {
            $value = ord($strng[$i]);
            if ($value > 127) {
                if ($value >= 192 && $value <= 223) {
                    $split = 2;
                } elseif ($value >= 224 && $value <= 239) {
                    $split = 3;
                } elseif ($value >= 240 && $value <= 247) {
                    $split = 4;
                }
            } else {
                $split = 1;
            }
            $key = NULL;
            for ($j = 0; $j < $split; $j++, $i++) {
                if($isLowerCase) {
                    $key .= strtolower($strng[$i]);
                } else {
                    $key .= $strng[$i];
                }
            }
            array_push($listsChars, $key);
        }
        return $listsChars;
    }
}