<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 10:58
 */

namespace Kind\Languages;


use Kind\Kind;

class Ukranian extends Kind
{

    const MORFER_FEMALE_MALE_MIDDLE = 5;
    const MORFER_MALE_MIDDLE = 4;

    protected $_vowelsLetters = [
        'a', 'є', 'и', 'і',
        'ї', 'о', 'у', 'ю',
        'я'
    ];

    protected $_consonantLetters = [
        'б', 'в', 'г', 'ґ',
        'д', 'ж', 'з', 'й',
        'к', 'л', 'м', 'н',
        'п', 'р', 'с', 'т',
        'ф', 'х', 'ц', 'ч',
        'ш','щ'
    ];

    protected $_number_text = [
        0 => 'нуль',
        1 => ['один', 'одна'],
        2 => ['два', 'дві'],
        3 => 'три',
        4 => ['чотири', 'чотири'],
        5 => "п&#39;ять",
        6 => 'шість',
        7 => 'сім',
        8 => 'вісім',
        9 => "дев&#39;ять",
        10 => 'десять',
        11 => '[:number]надцять',
        20 => '[:number]дцять [:subnumber]',
        40 => 'сорок [:subnumber]',
        50 => '[:number]десят [:subnumber]',
        90 => "дев&#39;яносто [:subnumber]",
        100 => 'сто [:subnumber]',
        200 => 'двісті [:subnumber]',
        300 => '[:number]ста [:subnumber]',
        500 => '[:number]сот [:subnumber]',
        1000 => '[:number:two] тисяча [:subnumber]',
        2000 => '[:number:two] тисячі [:subnumber]',
        5000 => '[:number] тисяч [:subnumber]',
        1000000 => '[:number] мільйон [:subnumber]',
        2000000 => '[:number] мільйона [:subnumber]',
        5000000 => '[:number] мільйонів [:subnumber]',
    ];

    protected $_code = 'uk_UK.utf-8';

    /**
     * Определение Женского рода по окончанию
     * @return bool
     */
    protected function isFemale()
    {
        $lettersEnd = ['а', 'ь', 'я'];
        $lettersEndNo = ['ла', 'ко'];
        $listsChras = \Letter::str_split_utf8($this->_wordInit, true);

        if(count($listsChras) > 0) {
            $lastChar = $listsChras[count($listsChras) - 1];
            $lastLetterTwo = implode('', [$listsChras[count($listsChras) - 2], $listsChras[count($listsChras) - 1]]);
            if(!in_array($lastLetterTwo, $lettersEndNo) && in_array($lastChar, $lettersEnd)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Определение Мужского рода по окончанию
     * @return bool
     */
    protected function isMale()
    {
        $lettersEnd = ['ла', 'ко'];
        $listsChras = \Letter::str_split_utf8($this->_wordInit, true);
        if(count($listsChras) > 0) {
            $lastLetter = $listsChras[count($listsChras) - 1];
            $lastLetterTwo = implode('', [$listsChras[count($listsChras) - 2], $listsChras[count($listsChras) - 1]]);
            if(in_array($lastLetter, $this->_consonantLetters)) {
                return true;
            }
            if(in_array($lastLetterTwo, $lettersEnd)) {
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
        $lettersEnd = ['а', 'е', 'о', '\'я'];
        $listsChras = \Letter::str_split_utf8($this->_wordInit, true);
        if(count($listsChras) > 0) {
            $lastLetter = $listsChras[count($listsChras) - 1];
            $lastLetterTwo = implode('', [$listsChras[count($listsChras) - 2], $listsChras[count($listsChras) - 1]]);
            return in_array($lastLetterTwo, $lettersEnd) || in_array($lastLetter, $lettersEnd);
        }

        return false;
    }

    /**
     * Какого рода слово
     * @return int
     */
    public function getTypeKind()
    {
        if($this->isMale()) {
            return Kind::MORFER_MALE;
        }

        if($this->isFemale()) {
            return Kind::MORFER_FEMALE;
        }

        if($this->isMiddle()) {
            return Kind::MORFER_MIDDLE;
        }

        return -1;
    }

    /**
     * Число превращаем в строку
     * @param int|float $number
     * @param bool $isInteger
     * @return string
     */
    protected function getTextNumber($number, $isInteger = true)
    {

        $isMinus = false;
        $returnNumber = null;
        $floatEnd = null;
        $returnText = null;
        if(is_float($number)) {
            $floatEnd = explode(',', str_replace('.', ',', $number))[1];
            $number = (int)$number;
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
            if ($lastNumber >= 5 && $lastNumber <= 10) {
                $getNumber = preg_replace("/ь$/", null, $getNumber);
            }

            $returnNumber = str_replace('[:number]', $getNumber, $this->_number_text[11]);
        }
        if ($number >= 20 && $number < 100) {
            $numbers = explode(',', str_replace('.', ',', $number / 10));
            $firstNumber = $this->_number_text[$numbers[0]];
            $LastNumber = $numbers[1] != 0 ? $this->_number_text[$numbers[1]] : null;
            $keyGet = 20;
            if (is_array($firstNumber) && isset($firstNumber[$keyNumberArray])) {
                $firstNumber = $firstNumber[$keyNumberArray];
            }
            if (is_array($LastNumber) && isset($firstNumber[$keyNumberArray])) {
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
            if ($numbers[0] >= 5 && $numbers[0] <= 10) {
                $firstNumber = preg_replace("/ь$/", null, $firstNumber);
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
                /** @var int $numberFirst */
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
            $returnText = "мінис {$returnNumber}";
        } else {
            $returnText = "{$returnNumber}";
        }

        if($floatEnd) {
            $returnText .= ', ' . $floatEnd;
        }

        return $returnText;
    }
}