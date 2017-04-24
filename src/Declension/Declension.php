<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 23.02.17
 * Time: 10:34
 */

namespace Declension;


use Symfony\Component\Yaml\Yaml;

abstract class Declension
{
    protected $_langCode;
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
    /**
     * @var string
     */
    protected $DelimiterInput = ' ';
    protected $_letterExclude = [];
    protected $_words = [];
    protected $_ABC = [];

    public function __construct($wordInput = null)
    {
        $this->_wordInput = $wordInput;
        if (!empty($this->_wordInput)) {
            $this->autoloadConfig();
            die(print_r($this->_ABC, true));
            $this->_listsLetters = \Letter::str_split_utf8($this->_wordInput);
            $this->_words = $this->getArraysLists();
            $this->setNominative();
            $this->setGenitive();
            $this->setDative();
            $this->setAccusative();
            $this->setInstrumental();
            $this->setPrepositional();
        }
    }

    private function autoloadConfig() {
        if($this->_langCode) {
            $lists = implode(DIRECTORY_SEPARATOR, [
                __DIR__,'..', 'Config', "ABC.{$this->_langCode}.yml"
            ]);
            if(realpath($lists)) {
                $yamlABC = Yaml::parse(file_get_contents(realpath($lists)));
                if(array_key_exists("abc.{$this->_langCode}", $yamlABC)) {
                    $this->_ABC = $yamlABC["abc.{$this->_langCode}"];
                }
            }
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

    /**
     * @return array
     */
    abstract protected function getArraysLists();

    /**
     * @param array $items
     * @return  array
     */
    protected function mapLetters($items)
    {
        $ex = $this->_letterExclude;
        $delimeter = [];
        $returnArray = array_filter(array_map(function ($item) use ($ex, &$delimeter) {
            if(!in_array($item, $ex)) {
                return \Letter::str_split_utf8($item);
            } else {
                if(!array_search($item, $delimeter)) {
                    array_push($delimeter, $item);
                }
                return false;
            }
        }, $items), function($item) {
            return $item != false;
        });

        if(count($delimeter) > 0) {
            $this->DelimiterInput .= implode(' ', $delimeter);
        }

        return $returnArray;
    }

    public function getResult()
    {
        return [
            'Nominative' => $this->Nominative,
            'Genitive' => $this->Genitive,
            'Dative' => $this->Dative,
//            'Accusative' => $this->Accusative,
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