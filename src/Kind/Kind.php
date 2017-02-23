<?php

/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 10:54
 */

namespace Kind;

abstract class Kind
{

    const MORFER_MALE   = 1;
    const MORFER_FEMALE = 2;
    const MORFER_MIDDLE = 3;

    protected $_wordInit = null;
    protected $_code = null;
    protected $_vowelsLetters = [];
    protected $_consonantLetters = [];
    protected $_number_text = [];

    public function __construct($word = null)
    {
        $this->_wordInit = $word;
        if(!empty($this->_code)) {
            setlocale(LC_ALL, $this->_code);
        }
    }

    /**
     * Какого рода слово
     * @return int
     */
    public function getTypeKind() {
        if($this->isMiddle()) {
            return Kind::MORFER_MIDDLE;
        }

        if($this->isMale()) {
            return Kind::MORFER_MALE;
        }

        if($this->isFemale()) {
            return Kind::MORFER_FEMALE;
        }

        return -1;
    }
    /**
     * Определение Женского рода по окончанию
     * @return bool
     */
    abstract protected function isFemale();
    /**
     * Определение Мужского рода по окончанию
     * @return bool
     */
    abstract protected function isMale();

    /**
     * Определение среднего рода
     * @return bool
     */
    abstract protected function isMiddle();

    /**
     * Число превращаем в строку
     * @param $number
     * @param bool $isInteger
     * @return string
     */
    abstract protected function getTextNumber($number, $isInteger = true);

    /**
     * @return null|string
     */
    public function getWord() {
        return $this->_wordInit;
    }

    /**
     * Число превращаем в текст
     * @return null|string
     */
    public function numberToText() {

        if(!is_numeric($this->_wordInit)) {
            return null;
        }

        return $this->getTextNumber($this->_wordInit);
    }



    /**
     * @param string $language
     * @param null $word
     * @return mixed|$this
     */
    public static function init($language = 'Russian', $word = null) {
        $getObject = 'Kind\Languages\\' .  $language;
        return new $getObject($word);
    }

}