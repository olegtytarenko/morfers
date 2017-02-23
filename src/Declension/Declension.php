<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 23.02.17
 * Time: 10:34
 */

namespace Declension;


abstract class Declension
{
    /**
     * Входящие слово
     * @var null
     */
    protected $_wordInput = null;
    /**
     * Массив букв
     * @var array
     */
    protected $_listsLetters = [];
    /**
     * Именительный
     * Називний
     * @var string
     */
    protected $Nominative;
    /**
     * Родительный
     * Родовий
     * @var string
     */
    protected $Genitive;
    /**
     * Дательный
     * Давальний
     * @var string
     */
    protected $Dative;
    /**
     * Винительный
     * Знахідний
     * @var string
     */
    protected $Accusative;
    /**
     * Творительный
     * Орудний
     * @var string
     */
    protected $Instrumental;
    /**
     * Предложный
     * Місцевий
     * @var string
     */
    protected $Prepositional;
    /**
     * Кличний - UA
     * @var string
     */
    protected $Vocative;

    public function __construct($wordInput = null)
    {
        $this->_wordInput = $wordInput;
        if (!empty($this->_wordInput)) {
            $this->_listsLetters = \Letter::str_split_utf8($this->_wordInput);
            $this->setNominative();
            $this->setGenitive();
            $this->setDative();
            $this->setAccusative();
            $this->setInstrumental();
            $this->setPrepositional();
        }
    }

    /**
     * Именительный - RU    <br>
     * Називний - UA
     * @return string
     */
    public function getNominative()
    {
        return $this->Nominative;
    }

    /**
     * Именительный - RU    <br>
     * Називний - UA
     */
    abstract protected function setNominative();

    /**
     * Родительный - RU    <br>
     * Родовий - UA
     * @return string
     */
    public function getGenitive()
    {
        return $this->Genitive;
    }

    /**
     * Родительный - RU    <br>
     * Родовий - UA
     */
    abstract protected function setGenitive();

    /**
     * Дательный - RU    <br>
     * Давальний - UA
     * @return string
     */
    public function getDative()
    {
        return $this->Dative;
    }

    /**
     * Дательный - RU    <br>
     * Давальний - UA
     */
    abstract protected function setDative();

    /**
     * Винительный - RU    <br>
     * Знахідний - UA
     * @return string
     */
    public function getAccusative()
    {
        return $this->Accusative;
    }

    /**
     * Винительный - RU    <br>
     * Знахідний - UA
     */
    abstract protected function setAccusative();

    /**
     * Творительный  - RU    <br>
     * Орудний  - UA
     * @return string
     */
    public function getInstrumental()
    {
        return $this->Instrumental;
    }

    /**
     * Творительный  - RU    <br>
     * Орудний  - UA
     */
    abstract protected function setInstrumental();

    /**
     * Предложный - RU    <br>
     * Місцевий  - UA
     * @return mixed
     */
    public function getPrepositional()
    {
        return $this->Prepositional;
    }

    /**
     * Предложный - RU    <br>
     * Місцевий  - UA
     */
    abstract protected function setPrepositional();

    /**
     * Кличний - UA
     * @return string
     */
    public function getVocative()
    {
        return $this->Vocative;
    }

    /**
     * Кличний - UA
     */
    abstract protected function setVocative();

    public function getResult()
    {
        return [
            'Nominative' => $this->Nominative,
            'Genitive' => $this->Genitive,
            'Dative' => $this->Dative,
            'Accusative' => $this->Accusative,
            'Instrumental' => $this->Instrumental,
            'Prepositional' => $this->Prepositional
        ];
    }

    /**
     * @param $Language
     * @param null $wordInput
     * @return $this
     */
    public static function init($Language, $wordInput = null)
    {
        $getNameSpace = __NAMESPACE__ . "\\Languages\\" . $Language;
        return new $getNameSpace($wordInput);
    }
}