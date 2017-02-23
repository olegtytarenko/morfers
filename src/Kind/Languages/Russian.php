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
        0 => 'ноль',
        1 => ['один', 'одна'],
        2 => ['два', 'две'],
        3 => 'три',
        4 => ['четыре', 'четыри'],
        5 => 'пять',
        6 => 'шесть',
        7 => 'семь',
        8 => 'восемь',
        9 => 'девять',
        10 => 'десять',
        11 => '[:number]надцать',
        20 => '[:number]дцать [:subnumber]',
        40 => 'сорок [:subnumber]',
        50 => '[:number]десят [:subnumber]',
        90 => 'девяносто [:subnumber]',
        100 => 'сто [:subnumber]',
        200 => 'двести [:subnumber]',
        300 => '[:number]ста [:subnumber]',
        500 => '[:number]сот [:subnumber]',
        1000 => '[:number:two] тысяча [:subnumber]',
        2000 => '[:number:two] тысячи [:subnumber]',
        5000 => '[:number] тысяч [:subnumber]',
        1000000 => '[:number] миллион [:subnumber]',
        2000000 => '[:number] миллиона [:subnumber]',
        5000000 => '[:number] миллионов [:subnumber]',
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

            if (in_array($twoLastLetters_four, ['енок', 'ёнок', 'онок'])) {
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

                if ($lastLetter == 'ь' && $haveLetter && $haveLastLetter && $notSuffix) {
                    return $threeLastLetters . $consonantLetter . 'ь';
                } elseif (in_array($lastLetter, ['а', 'я']) && $haveSuffix) {
                    return $threeLastLetters . $consonantLetter . $lastLetter;
                } else {
                    return false;
                }
            }, $this->_consonantLetters), $lettersEnd, $this->_consonantLetters);


            $lettersEnd = array_values(array_filter($listsLettersTreeEnd, function ($item) {
                return $item != false;
            }));


            if (in_array($twoLastLetters_three, $lettersEnd)) {
                return true;
            }

            if (in_array($twoLastLetters, $lettersEnd)) {
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
            if ($twoLastLetters == 'мя') {
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
    protected function getTextNumber($number, $isInteger = false)
    {
        $isMinus = false;
        $returnNumber = null;
        $floatEnd = null;
        $returnText = null;
        if(is_float($number)) {
            $floatEnd = explode(',', $number)[1];
        }

        if ($number < 0) {
            $number = $number * -1;
            $isMinus = true;
        }
        $keyNumberArray = 0;
        if($isInteger) {
            $keyNumberArray = 1;
        }
        if ($number < 11) {
            $getNumber = $this->_number_text[$number];
            if (is_array($getNumber)) {
                $returnNumber = $getNumber[$keyNumberArray];
            } else {
                $returnNumber = $getNumber;
            }
        }
        if ($number > 10 && $number < 20) {
            $lastNumber = $number % 10;
            $getNumber = $this->_number_text[$lastNumber];
            if (is_array($getNumber)) {
                $getNumber = $getNumber[0];
            }
            if ($lastNumber > 5 && $lastNumber < 10) {
                $getNumber = preg_replace("/ь$/", null, $getNumber);
            }

            $returnNumber = str_replace('[:number]', $getNumber, $this->_number_text[11]);
        }
        if ($number >= 20 && $number < 100) {
            $numbers = explode(',', $number / 10);
            $firstNumber = $this->_number_text[$numbers[0]];
            $LastNumber = $numbers[1] != 0 ? $this->_number_text[$numbers[1]] : null;
            $keyGet = 20;
            if (is_array($firstNumber)) {
                $firstNumber = $firstNumber[$keyNumberArray];
            }
            if (is_array($LastNumber)) {
                $LastNumber = $LastNumber[$keyNumberArray];
            }
            if ($number >= 40) {
                $keyGet = 40;
            }
            if ($number >= 50) {
                $keyGet = 50;
            }
            if ($number >= 90 && $number < 100) {
                $keyGet = 90;
            }
            $returnNumber = str_replace(['[:number]', '[:subnumber]'], [$firstNumber, $LastNumber], $this->_number_text[$keyGet]);
        }
        if ($number >= 100 && $number < 1000) {
            $LastNumbers = ($number % 100);
            $firstNumber = ($number / 100) % 10;
            $twoNumber = null;
            if ($LastNumbers > 0) {
                $twoNumber = $this->getTextNumber($LastNumbers);
            }
            $keyGet = 100;

            if ($number >= 200) {
                $keyGet = 200;
            }
            if ($number >= 300) {
                $keyGet = 300;
            }

            if ($number >= 500) {
                $keyGet = 500;
            }

            if (in_array($keyGet, [200, 100])) {
                $firstNumber = null;
            }

            if ($firstNumber) {
                $firstNumber = $this->_number_text[$firstNumber];
                if (is_array($firstNumber)) {
                    $firstNumber = $firstNumber[0];
                }
            }
            $returnNumber = str_replace(['[:number]', '[:subnumber]'], [$firstNumber, $twoNumber], $this->_number_text[$keyGet]);
        }
        if ($number >= 1000 && $number < pow(10, 6)) {
            $numberTwo = $Number = null;
            $numberFirst = ($number / 1000);
            if(($numberFirst % 10 == 1 || $numberFirst % 100 == 1) && $numberFirst % 100 != 11) {
                $keyGet = 1000;
            } elseif (
                (($numberFirst % 10 >= 2 || $numberFirst % 100 >= 2) && ($numberFirst % 10 <= 4 || $numberFirst % 100 <= 4 )) &&
                (($numberFirst % 10 < 10 || $numberFirst % 100 < 10) && ($numberFirst % 100 != 11) && ($numberFirst % 10 >= 20 || $numberFirst % 100 >= 20))
            ) {
                $keyGet = 2000;
            } else {
                $keyGet = 5000;
            }

            if ($numberFirst > 10) {
                $Number = $numberTwo = $this->getTextNumber($numberFirst % 1000, $numberFirst % 10 == 1);
            } else {
                $Number = $this->_number_text[$numberFirst];
                if (is_array($Number)) {
                    $numberTwo = $Number[1];
                    $Number = $Number[0];
                }
            }


            $twoNumber = $this->getTextNumber($number % 1000);
            $returnNumber = str_replace(['[:number]', '[:number:two]', '[:subnumber]'], [$Number, $numberTwo, $twoNumber], $this->_number_text[$keyGet]);

        }
        if($number >= pow(10, 6)) {

        }


        if ($isMinus) {
            $returnText = "минус {$returnNumber}";
        } else {
            $returnText = "{$returnNumber}";
        }

        if($floatEnd) {
            $returnText .= ', ' . $floatEnd;
        }

        return $returnText;
    }
}