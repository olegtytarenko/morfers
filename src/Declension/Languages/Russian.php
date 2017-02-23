<?php

namespace Declension\Languages;

use Declension\Declension;

/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 23.02.17
 * Time: 10:35
 */
class Russian extends Declension
{
    private $_consonantLetters = [
        'б', 'в', 'г', 'д',
        'ж', 'з', 'й', 'к',
        'л', 'м', 'н', 'п',
        'р', 'с', 'т', 'ф',
        'х', 'ц', 'ч', 'ш',
        'щ'
    ];

    protected $_vowelsLetters = [
        'а', 'у', 'о', 'ы',
        'и', 'э', 'я', 'ю',
        'ё', 'е'
    ];

    /**
     * Именительный - RU    <br>
     * Називний - UA
     */
    protected function setNominative()
    {
        $this->Nominative = $this->_wordInput;
    }

    /** test
     * Родительный - RU    <br>
     * Родовий - UA
     */
    protected function setGenitive()
    {
        $words = explode(' ', $this->_wordInput);
        if (count($words) > 1) {
            for ($wordSet = [], $i = 0; $i < count($words); $i++) {
                $wordSet[] = $this->setDeclareWordGenitive(\Letter::str_split_utf8($words[$i]));
            }
            $this->Genitive = implode(' ', $wordSet);
        } else {
            $this->Genitive = $this->setDeclareWordGenitive($this->_listsLetters);
        }
    }

    private function setDeclareWordGenitive($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);

        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                if (in_array($twoLetters, ['га', 'ка'])) {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'ы';
                }
            }
            if ($lastLetter == 'я') {
                $listsLetter[count($listsLetter) - 1] = 'и';
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($listsLetter[count($listsLetter) - 3] != 'ь' && in_array($twoLetters, ['ет', 'ец'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }
            array_push($listsLetter, 'а');
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL)) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'я';
            }
        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {
            if (in_array($twoLetters, ['ло'])) {
                $listsLetter[count($listsLetter) - 1] = 'а';
            }
            if (in_array($twoLetters, ['ий', 'ле', 'ие'])) {
                $listsLetter[count($listsLetter) - 1] = 'я';
            }

            if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), ['ые'])) {
                $listsLetter[count($listsLetter) - 1] = 'х';
            } elseif (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), ['ый'])) {
                $listsLetter[count($listsLetter) - 1] = 'ого';
                unset($listsLetter[count($listsLetter) - 2]);
            } elseif (in_array($lastLetter, ['и'])) {
                $listsLetter[count($listsLetter) - 1] = 'ов';
            }
        }
        return implode('', $listsLetter);
    }

    /**
     * test
     * Дательный - RU    <br>
     * Давальний - UA
     */
    protected function setDative()
    {
        $words = explode(' ', $this->_wordInput);
        if (count($words) > 1) {
            for ($wordSet = [], $i = 0; $i < count($words); $i++) {
                $wordSet[] = $this->setDeclareWordDative(\Letter::str_split_utf8($words[$i]));
            }
            $this->Dative = implode(' ', $wordSet);
        } else {
            $this->Dative = $this->setDeclareWordDative($this->_listsLetters);
        }
    }

    private function setDeclareWordDative($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $letter_a_ya = ['а', 'я'];

        if (in_array($lastLetter, $letter_a_ya)) {
            if ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif ($twoLetters == 'ля') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'и';
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($listsLetter[count($listsLetter) - 3] != 'ь' && in_array(implode('', [
                    $listsLetter[count($listsLetter) - 2], $listsLetter[count($listsLetter) - 1]
                ]), ['ет', 'ец'])
            ) {
                unset($listsLetter[count($listsLetter) - 2]);
            }
            array_push($listsLetter, 'у');
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL)) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            }
        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {
            if (in_array($twoLetters, ['ло'])) {
                $listsLetter[count($listsLetter) - 1] = 'у';
            }
            if (in_array($twoLetters, ['ий', 'ле', 'ие'])) {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            }
            if (in_array($twoLetters, ['ые'])) {
                $listsLetter[count($listsLetter) - 1] = 'м';
            } elseif (in_array($twoLetters, ['ый'])) {
                $listsLetter[count($listsLetter) - 1] = 'ому';
                unset($listsLetter[count($listsLetter) - 2]);
            } elseif (in_array($lastLetter, ['и'])) {
                $listsLetter[count($listsLetter) - 1] = 'ам';
            }
        }

        return implode('', $listsLetter);
    }

    /**
     * Винительный - RU    <br>
     * Знахідний - UA
     */
    protected function setAccusative()
    {
        $words = explode(' ', $this->_wordInput);
        if (count($words) > 1) {
            for ($wordSet = [], $i = 0; $i < count($words); $i++) {
                $wordSet[] = $this->setDeclareWordAccusative(\Letter::str_split_utf8($words[$i]));
            }
            $this->Accusative = implode(' ', $wordSet);
        } else {
            $this->Accusative = $this->setDeclareWordAccusative($this->_listsLetters);
        }
    }

    private function setDeclareWordAccusative($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'у';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            }
            $this->Accusative = implode('', $listsLetter);
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if (
                !in_array($twoLetters, ['ет', 'пр', 'ег']) &&
                (in_array($twoLetters, ['ад', 'йн', 'мм']) || in_array($lastLetter, ['с', 'т', 'р', 'г']))
            ) {
                $listsLetter[] = 'а';
            }
            if ($listsLetter[count($listsLetter) - 3] != 'ь' && in_array(implode('', [
                    $listsLetter[count($listsLetter) - 3], $twoLetters
                ]), ['вец'])
            ) {
                unset($listsLetter[count($listsLetter) - 2]);
                $listsLetter[] = 'а';
            }
            $this->Accusative = implode('', $listsLetter);
        } elseif ($lastLetter == 'ь') {
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $this->_consonantLetters);
            if (!in_array($twoLetters, $listsCL)) {
                $listsLetter[count($listsLetter) - 1] = 'я';
            }
            $this->Accusative = implode('', $listsLetter);
        } elseif (in_array($lastLetter, ['о', 'й', 'е'])) {
            $this->Accusative = implode('', $listsLetter);
            if (in_array($twoLetters, ['ий'])) {
                $listsLetter[count($listsLetter) - 1] = 'я';
                $this->Accusative = implode('', $listsLetter);
            }
        }

        return implode('', $listsLetter);
    }

    /**
     * Творительный  - RU    <br>
     * Орудний  - UA
     */
    protected function setInstrumental()
    {
        $listsLetter = $this->_listsLetters;
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'ой';
            }
            if ($lastLetter == 'я') {
                $listsLetter[count($listsLetter) - 1] = 'ей';
            }

            $this->Instrumental = implode('', $listsLetter);
        }

        if (!$this->Instrumental) {
            if ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
                array_push($listsLetter, 'ом');
                $this->Instrumental = implode('', $listsLetter);
            }
        }

        if (!$this->Instrumental) {
            if ($lastLetter == 'ь') {
                $listsCL = array_map(function ($item) use ($lastLetter) {
                    return $item . $lastLetter;
                }, $this->_consonantLetters);
                if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), $listsCL)) {
                    array_push($listsLetter, 'ю');
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'ём';
                }

                $this->Instrumental = implode('', $listsLetter);
            }
        }

        if (!$this->Instrumental) {
            if (in_array($lastLetter, ['о', 'й', 'е'])) {
                if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), ['ло'])) {
                    $listsLetter[count($listsLetter) - 1] = 'ом';
                    $this->Instrumental = implode('', $listsLetter);
                }
                if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), ['ий', 'ле', 'ие'])) {
                    $listsLetter[count($listsLetter) - 1] = 'ем';
                    $this->Instrumental = implode('', $listsLetter);
                }
            }
        }
    }

    /**
     * Предложный - RU    <br>
     * Місцевий  - UA
     */
    protected function setPrepositional()
    {
        $listsLetter = $this->_listsLetters;
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                array_unshift($listsLetter, ' ');
                array_unshift($listsLetter, 'о');

                $listsLetter[count($listsLetter) - 1] = 'е';
            }
            if ($lastLetter == 'я') {
                array_unshift($listsLetter, ' ');
                if (implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]) == 'ия') {
                    array_unshift($listsLetter, 'об');
                } else {
                    array_unshift($listsLetter, 'о');
                }
                if (implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]) == 'ля') {
                    $listsLetter[count($listsLetter) - 1] = 'е';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                }
            }

            $this->Prepositional = implode('', $listsLetter);
        }
        if (!$this->Prepositional) {
            if ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
                array_unshift($listsLetter, ' ');
                array_unshift($listsLetter, 'о');
                array_push($listsLetter, 'е');
                $this->Prepositional = implode('', $listsLetter);
            }
        }

        if (!$this->Prepositional) {
            if ($lastLetter == 'ь') {
                array_unshift($listsLetter, ' ');
                array_unshift($listsLetter, 'о');
                $listsCL = array_map(function ($item) use ($lastLetter) {
                    return $item . $lastLetter;
                }, $this->_consonantLetters);
                if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), $listsCL)) {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'е';
                }
                $this->Prepositional = implode('', $listsLetter);
            }
        }

        if (!$this->Prepositional) {
            if (in_array($lastLetter, ['о', 'й', 'е'])) {
                array_unshift($listsLetter, ' ');
                array_unshift($listsLetter, 'о');
                if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), ['ло', 'ле'])) {
                    $listsLetter[count($listsLetter) - 1] = 'е';
                    $this->Prepositional = implode('', $listsLetter);
                }
                if (in_array(implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]), ['ий', 'ие'])) {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                    $this->Prepositional = implode('', $listsLetter);
                }
            }
        }
    }

    /**
     * Кличний - UA
     */
    protected function setVocative()
    {
        $this->Vocative = null;
    }
}