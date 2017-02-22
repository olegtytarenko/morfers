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
     * @return string
     */
    protected function getTextNumber($number, $isInteger = true)
    {
        // TODO: Implement getTextNumber() method.
    }
}