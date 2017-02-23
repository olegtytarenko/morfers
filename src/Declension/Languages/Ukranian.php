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
     * Родовий - UA
     */
    protected function setGenitive()
    {
        // TODO: Implement setGenitive() method.
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
}