<?php

namespace Declension\Languages;
use Declension\Declension;

/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 23.02.17
 * Time: 10:35
 */
class Ukranian extends Declension
{

   protected $_langCode = 'uk';

    /**
     * Именительный - RU    <br>
     * Називний - UA
     */
    protected function setNominative()
    {
        $this->Nominative = $this->_wordInput;
    }

    /**
     * Родительный - RU    <br>
     * Родовий - UA нема кого? чого?
     */
    protected function setGenitive()
    {
        $lastCount = count($this->_listsLetters) - 1;
        $lasChild = $this->_listsLetters[$lastCount];
        $pervChild = $this->_listsLetters[$lastCount - 1];
        if(in_array($lasChild, ['а', 'й', 'я'])) {
            if(in_array($pervChild, ['і'])) {
                $this->_listsLetters[count($this->_listsLetters) - 1] = 'ю';
            } else {
                $this->_listsLetters[count($this->_listsLetters) - 1] = 'у';
            }
        } else {
            if(in_array($pervChild, ['е'])) {
                unset($this->_listsLetters[$lastCount - 1]);
            }
            $this->_listsLetters[] = 'у';
        }

        $this->Genitive = implode('', $this->_listsLetters);
    }

    /**
     * Дательный - RU    <br>
     * Давальний - UA
     */
    protected function setDative()
    {
        // TODO: Implement setDative() method.
    }

    /**
     * Винительный - RU    <br>
     * Знахідний - UA
     */
    protected function setAccusative()
    {
        // TODO: Implement setAccusative() method.
    }

    /**
     * Творительный  - RU    <br>
     * Орудний  - UA
     */
    protected function setInstrumental()
    {
        // TODO: Implement setInstrumental() method.
    }

    /**
     * Предложный - RU    <br>
     * Місцевий  - UA
     */
    protected function setPrepositional()
    {
        // TODO: Implement setPrepositional() method.
    }

    /**
     * Кличний - UA
     */
    protected function setVocative()
    {
        // TODO: Implement setVocative() method.
    }

    /**
     * @return array
     */
    protected function getArraysLists()
    {
        // TODO: Implement getArraysLists() method.
    }
}