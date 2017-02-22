<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 10:56
 */

namespace Kind\Languages;


use Kind\Kind;

class Russian extends Kind
{
    protected $_code = 'ru_RU.utf-8';
    protected $_vowelsLetters = [
        'а', 'у', 'о', 'ы',
        'и', 'э', 'я', 'ю',
        'ё', 'е'
    ];
    protected $_consonantLetters = [
        'б', 'в', 'г', 'д',
        'ж', 'з', 'й', 'к',
        'л', 'м', 'н', 'п',
        'р', 'с', 'т', 'ф',
        'х', 'ц', 'ч', 'ш',
        'щ'
    ];

    protected $_number_text = [
        0       =>   'ноль',
        1       =>   ['один', 'одна'],
        2       =>   ['два', 'две'],
        3       =>   'три',
        4       =>   ['четыре', 'четыри'],
        5       =>   'пять',
        6       =>   'шесть',
        7       =>   'семь',
        8       =>   'восемь',
        9       =>   'девять',
        10      =>   'десять',
        11      =>   '[:number]надцать',
        20      =>   '[:number]дцать [:subnumber]',
        40      =>   'сорок [:subnumber]',
        50      =>   '[:number]десят [:subnumber]',
        90      =>   'девяносто [:subnumber]',
        100     =>   'сто [:subnumber]',
        200     =>   'двести [:subnumber]',
        300     =>   '[:number]ста [:subnumber]',
        500     =>   '[:number]сот [:subnumber]',
        1000    =>   '[:number:two] тысяча',
        5000    =>   '[:number] тысяч',
        1000000 =>   '[:number] миллион',
        2000000 =>   '[:number] миллиона',
        5000000 =>   '[:number] миллионов',
    ];


    /**
     * Определение Женского рода по окончанию
     * @return bool
     */
    protected function isFemale()
    {
        $lettersEnd = ['а', 'я', 'ь'];
        $listsChars = \Letter::str_split_utf8($this->_wordInit, true);
        if (count($listsChars) > 0) {
            return in_array($listsChars[count($listsChars) - 1], $lettersEnd);
        }
        return false;
    }

    /**
     * Определение Мужского рода по окончанию
     * @return bool
     */
    protected function isMale()
    {
        $lettersEnd = ['й'];
        $listsChars = \Letter::str_split_utf8($this->_wordInit, true);
        if (count($listsChars) > 0) {
            $twoLastLetters = implode('', [$listsChars[count($listsChars) - 2], $listsChars[count($listsChars) - 1]]);
            $twoLastLetters_three = implode('', [$listsChars[count($listsChars) - 3], $listsChars[count($listsChars) - 2], $listsChars[count($listsChars) - 1]]);
            $twoLastLetters_four = implode('', [$listsChars[count($listsChars) - 4], $listsChars[count($listsChars) - 3], $listsChars[count($listsChars) - 2], $listsChars[count($listsChars) - 1]]);
            $threeLastLetters = $listsChars[count($listsChars) - 3];
            $lastLetter = $listsChars[count($listsChars) - 1];

            if(in_array($twoLastLetters_four, ['енок', 'ёнок', 'онок'])) {
                return true;
            }

            $lettersEnd = array_merge(array_map(function ($consonantLetter) {
                if (!in_array($consonantLetter, ['д', 'ч', 'т', 'л', 'р', 'п', 'в'])) {
                    return $consonantLetter . 'ь';
                } else {
                    return false;
                }
            }, $this->_consonantLetters), $lettersEnd);

            $listsLettersTreeEnd = array_merge(array_map(function ($consonantLetter) use ($threeLastLetters, $lastLetter) {
                $haveLetter = in_array($consonantLetter, ['р', 'н', 'л', 'б', 'д']);
                $haveLastLetter = in_array($threeLastLetters, ['у', 'о', 'а', 'я', 'б', 'ж', 'e']);
                $notSuffix = !in_array($threeLastLetters . $consonantLetter, ['ал', 'ад', 'ат', 'ер', 'еп', 'ов']);
                $haveSuffix = in_array($threeLastLetters . $consonantLetter, ['ин', 'ош', 'шк', 'ап', 'яд']);

                if($lastLetter == 'ь' && $haveLetter && $haveLastLetter && $notSuffix) {
                    return $threeLastLetters . $consonantLetter . 'ь';
                } elseif (in_array($lastLetter, ['а', 'я']) && $haveSuffix) {
                    return $threeLastLetters . $consonantLetter . $lastLetter;
                }  else {
                    return false;
                }
            }, $this->_consonantLetters), $lettersEnd, $this->_consonantLetters);


            $lettersEnd = array_values(array_filter($listsLettersTreeEnd, function ($item) {
                return $item != false;
            }));


            if(in_array($twoLastLetters_three, $lettersEnd)) {
                return true;
            }

            if(in_array($twoLastLetters, $lettersEnd)) {
                return true;
            }

            if (in_array($lastLetter, $this->_consonantLetters)) {
                return true;
            }

        }
        return false;
    }

    /**
     * Определение среднего рода
     * @return bool
     */
    protected function isMiddle()
    {
        $lettersEnd = ['о', 'е', 'мя', 'и', 'у'];
        $listsChars = \Letter::str_split_utf8($this->_wordInit, true);
        if (count($listsChars) > 0) {
            $twoLastLetters = implode('', [$listsChars[count($listsChars) - 2], $listsChars[count($listsChars) - 1]]);
            if($twoLastLetters == 'мя') {
                return true;
            }
            return in_array($listsChars[count($listsChars) - 1], $lettersEnd);
        }
        return false;
    }

    /**
     * Число превращаем в строку
     * @param $number
     * @param bool $isInteger
     * @return null|string
     */
    protected function getTextNumber($number, $isInteger = true)
    {
        $isMinus = false;
        $returnNumber = null;

        if($number < 0) {
            $number = $number * -1;
            $isMinus = true;
        }

        if($number < 11) {
            $getNumber = $this->_number_text[$number];
            if(is_array($getNumber)) {
                $returnNumber = $getNumber[0];
            } else {
                $returnNumber = $getNumber;
            }
        }

        if($number > 10 && $number < 20) {
            $lastNumber = $number % 10;
            $getNumber = $this->_number_text[$lastNumber];
            if(is_array($getNumber)) {
                $getNumber = $getNumber[0];
            }
            if($lastNumber > 5 && $lastNumber < 10) {
                $getNumber = preg_replace("/ь$/", null, $getNumber);
            }

            $returnNumber = preg_replace('/\[\:number\]/', $getNumber, $this->_number_text[11]);
        }

        if($number >= 20 && $number < 40) {

        }



        if($isMinus) {
            return "минус {$returnNumber}";
        } else {
            return "{$returnNumber}";
        }
    }
}