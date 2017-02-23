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
        $threLt = null;
        if(isset($listsLetter[count($listsLetter) - 3])) {
            $threLt = $listsLetter[count($listsLetter) - 3];
        }
        if(in_array($twoLetters, ['би'])) {
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                if (in_array($twoLetters, ['га', 'ка']) || in_array($listsLetter[count($listsLetter) - 2], ['ж', 'ш', 'х'])) {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'ы';
                }
            }
            if ($lastLetter == 'я') {
                $listsLetter[count($listsLetter) - 1] = 'и';
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($threLt != 'ь' && in_array($twoLetters, ['ет', 'ец'])) {
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
        $threLt = null;
        if(isset($listsLetter[count($listsLetter) - 3])) {
            $threLt = $listsLetter[count($listsLetter) - 3];
        }
        if(in_array($twoLetters, ['би'])) {
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, $letter_a_ya)) {
            if ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif ($twoLetters == 'ля') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'и';
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($threLt != 'ь' && in_array($twoLetters, ['ет', 'ец'])) {
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
        $treeLetters = [];
        $tlThree = null;
        if(isset($listsLetter[count($listsLetter) - 3])) {
            $treeLetters = implode('', [$listsLetter[count($listsLetter) - 3], $twoLetters]);
            $tlThree = $listsLetter[count($listsLetter) - 3];
        }

        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'у';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            }
            $this->Accusative = implode('', $listsLetter);
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if (
                (!in_array($twoLetters, ['ет', 'пр', 'ег']) && !in_array($treeLetters, ['янг', 'кан', 'жан', 'дин'])) &&
                (in_array($twoLetters, ['ад', 'йн', 'мм', 'ан', 'ин', 'он']) || in_array($lastLetter, ['с', 'т', 'р', 'г', 'в', 'л']))
            ) {
                $listsLetter[] = 'а';
            }
            if ($tlThree != 'ь' && in_array($treeLetters, ['вец'])) {
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
        $words = explode(' ', $this->_wordInput);
        if (count($words) > 1) {
            for ($wordSet = [], $i = 0; $i < count($words); $i++) {
                $wordSet[] = $this->setDeclareWordInstrumental(\Letter::str_split_utf8($words[$i]));
            }
            $this->Instrumental = implode(' ', $wordSet);
        } else {
            $this->Instrumental = $this->setDeclareWordInstrumental($this->_listsLetters);
        }
    }

    private function setDeclareWordInstrumental($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $threeLetters = [];
        $tlThree = null;
        if(isset($listsLetter[count($listsLetter) - 3])) {
            $threeLetters = implode('', [$listsLetter[count($listsLetter) - 3], $twoLetters]);
            $tlThree = $listsLetter[count($listsLetter) - 3];
        }

        $fourLetters = [];
        if(isset($listsLetter[count($listsLetter) - 4])) {
            $fourLetters = implode('', [$listsLetter[count($listsLetter) - 4], $threeLetters]);
        }

        if(in_array($twoLetters, ['би'])) {
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                if (in_array($twoLetters, ['жа']) && !in_array($fourLetters, ['уджа'])) {
                    $listsLetter[count($listsLetter) - 1] = 'ей';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'ой';
                }
            }
            if ($lastLetter == 'я') {
                $listsLetter[count($listsLetter) - 1] = 'ей';
            }

        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($tlThree != 'ь' && in_array($twoLetters, ['ет', 'ец'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }
            if (in_array($threeLetters, ['вец'])) {
                array_push($listsLetter, 'ем');
            } else {
                if ((in_array($lastLetter, ['в']) || in_array($twoLetters, ['ин'])) && !in_array($threeLetters, ['дин'])) {
                    array_push($listsLetter, 'ым');
                } else {
                    array_push($listsLetter, 'ом');
                }
            }
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL)) {
                array_push($listsLetter, 'ю');
            } else {
                $listsLetter[count($listsLetter) - 1] = 'ем';
            }

        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {

            if (in_array($twoLetters, ['ло'])) {
                $listsLetter[count($listsLetter) - 1] = 'ом';
            } elseif (in_array($twoLetters, ['ий', 'ле', 'ие'])) {
                $listsLetter[count($listsLetter) - 1] = 'ем';
            } elseif (in_array($lastLetter, ['и'])) {
                $listsLetter[count($listsLetter) - 1] = 'ами';
            } elseif (in_array($twoLetters, ['ые'])) {
                $listsLetter[count($listsLetter) - 1] = 'ми';
            } elseif (in_array($twoLetters, ['ый'])) {
                $listsLetter[count($listsLetter) - 1] = 'м';
            } elseif (in_array($lastLetter, ['е']) && !in_array($twoLetters, ['ме', 'че'])) {
                $listsLetter[] = 'й';
            }
        }

        return implode('', $listsLetter);
    }

    /**
     * Предложный - RU    <br>
     * Місцевий  - UA
     */
    protected function setPrepositional()
    {
        $words = explode(' ', $this->_wordInput);
        if (count($words) > 1) {
            for ($wordSet = [], $i = 0; $i < count($words); $i++) {
                $wordSet[] = $this->setDeclareWordPrepositional(\Letter::str_split_utf8($words[$i]), $i);
            }
            $this->Prepositional = implode(' ', $wordSet);
        } else {
            $this->Prepositional = $this->setDeclareWordPrepositional($this->_listsLetters);
        }
    }

    private function setDeclareWordPrepositional($listsLetter, $wordCount = 0)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $firstLetter = strtolower($listsLetter[0]);
        $tlThree = null;
        if(isset($listsLetter[count($listsLetter) - 3])) {
            $tlThree = $listsLetter[count($listsLetter) - 3];
        }


        if(in_array($twoLetters, ['би'])) {
            if ($wordCount == 0) {
                array_unshift($listsLetter, ' ');
                if (in_array($firstLetter, ['и', 'И', 'А', 'а', 'Э', 'э'])) {
                    array_unshift($listsLetter, 'об');
                } else {
                    array_unshift($listsLetter, 'о');
                }
            }
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, ['а', 'я'])) {
            if ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            }
            if ($lastLetter == 'я') {
                if ($twoLetters == 'ля') {
                    $listsLetter[count($listsLetter) - 1] = 'е';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                }
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($tlThree != 'ь' && in_array($twoLetters, ['ет', 'ец'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }

            array_push($listsLetter, 'е');
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL)) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'е';
            }

        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {
            if (in_array($twoLetters, ['ло', 'ле'])) {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif (in_array($twoLetters, ['ий', 'ие'])) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } elseif (in_array($lastLetter, ['е']) && !in_array($twoLetters, ['ее', 'ме', 'че'])) {
                $listsLetter[count($listsLetter) - 1] = 'х';
            } elseif (in_array($lastLetter, ['и'])) {
                $listsLetter[count($listsLetter) - 1] = 'ах';
            } elseif (in_array($lastLetter, ['й']) && !in_array($twoLetters, ['эй'])) {
                $listsLetter[count($listsLetter) - 1] = 'ом';
                unset($listsLetter[count($listsLetter) - 2]);
            }
        }

        if ($wordCount == 0) {
            array_unshift($listsLetter, ' ');
            if (in_array($firstLetter, ['и', 'И', 'А', 'а', 'Э', 'э'])) {
                array_unshift($listsLetter, 'об');
            } else {
                array_unshift($listsLetter, 'о');
            }
        }
        return implode('', $listsLetter);
    }

    /**
     * Кличний - UA
     */
    protected function setVocative()
    {
        $this->Vocative = null;
    }
}