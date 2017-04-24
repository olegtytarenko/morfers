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
    protected $_langCode = 'ru';

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

    protected $_letterExclude = ['Интернэшинл'];

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
        if (count($this->_words) > 1) {
            $getThis = &$this;
            $this->Genitive = implode($this->DelimiterInput, array_map(function ($item) use ($getThis) {
                return $getThis->setDeclareWordGenitive($item);
            }, $this->_words));
        } else {
            if($this->DelimiterInput != ' ') {
                $this->Genitive = $this->setDeclareWordGenitive($this->_words[0]) . $this->DelimiterInput;
            } else {
                $this->Genitive = $this->setDeclareWordGenitive($this->_words[0]);
            }
        }
    }

    private function setDeclareWordGenitive($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $threLt = null;
        $threeLetters = null;
        if (isset($listsLetter[count($listsLetter) - 3])) {
            $threLt = $listsLetter[count($listsLetter) - 3];
            $threeLetters = implode('', [$threLt, $twoLetters]);
        }
        if (in_array($twoLetters, ['би'])) {
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, ['а', 'я'])) {
            if(in_array($twoLetters, ['уа'])) {
                array_pop($listsLetter);
                $listsLetter[count($listsLetter) - 1] = 'ы';
            } elseif ($lastLetter == 'а') {
                if (in_array($twoLetters, ['га', 'ка']) || in_array($listsLetter[count($listsLetter) - 2], ['ж', 'ш', 'х'])) {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'ы';
                }
            }
            if ($lastLetter == 'я') {
                if(in_array($twoLetters, ['ья'])) {
                    array_pop($listsLetter);
                    $listsLetter[count($listsLetter) - 1] = 'ий';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                }
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($threLt != 'ь' && in_array($twoLetters, ['ет', 'ец']) && !in_array($threeLetters, ['лет'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }
            if(in_array($twoLetters, ['лл'])) {
                array_push($listsLetter, 'у');
            } else {
                array_push($listsLetter, 'а');
            }
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL) || in_array($threeLetters, ['ель'])) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'я';
            }
        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {
            if (in_array($twoLetters, ['ло'])) {
                $listsLetter[count($listsLetter) - 1] = 'а';
            } elseif (in_array($twoLetters, ['ые']) || in_array($threeLetters, ['кие'])) {
                $listsLetter[count($listsLetter) - 1] = 'х';
            } elseif (in_array($twoLetters, ['ий', 'ле', 'ие', 'ай', 'эй'])) {
                $listsLetter[count($listsLetter) - 1] = 'я';
            } elseif (in_array($twoLetters, ['ый'])) {
                $listsLetter[count($listsLetter) - 1] = 'ого';
                unset($listsLetter[count($listsLetter) - 2]);
            } elseif (in_array($twoLetters, ['ии'])) {
                $listsLetter[count($listsLetter) - 1] = 'й';
            } elseif (in_array($twoLetters, ['ни'])) {
                $listsLetter[count($listsLetter) - 1] = 'ей';
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
        if (count($this->_words) > 1) {
            $getThis = &$this;
            $this->Dative = implode($this->DelimiterInput, array_map(function ($item) use ($getThis) {
                return $getThis->setDeclareWordDative($item);
            }, $this->_words));
        } else {
            if($this->DelimiterInput != ' ') {
                $this->Dative = $this->setDeclareWordDative($this->_words[0]) . $this->DelimiterInput;
            } else {
                $this->Dative = $this->setDeclareWordDative($this->_words[0]);
            }
        }
    }

    private function setDeclareWordDative($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $letter_a_ya = ['а', 'я'];
        $threLt = null;
        $threeLetters = null;
        if (isset($listsLetter[count($listsLetter) - 3])) {
            $threLt = $listsLetter[count($listsLetter) - 3];
            $threeLetters = implode('', [$threLt, $twoLetters]);
        }
        if (in_array($twoLetters, ['би'])) {
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, $letter_a_ya)) {
            if(in_array($twoLetters, ['уа'])) {
                array_pop($listsLetter);
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif ($lastLetter == 'а' || $twoLetters == 'ля') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif(in_array($twoLetters, ['ья'])) {
                $listsLetter[] = 'м';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'и';
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($threLt != 'ь' && in_array($twoLetters, ['ет', 'ец']) && !in_array($threeLetters, ['лет'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }
            if(in_array($twoLetters, ['лл'])) {
                array_push($listsLetter, 'е');
            } else {
                array_push($listsLetter, 'у');
            }
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL) || in_array($threeLetters, ['ель'])) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            }
        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {
            if (in_array($twoLetters, ['ло'])) {
                $listsLetter[count($listsLetter) - 1] = 'у';
            } elseif (in_array($twoLetters, ['ые']) || in_array($threeLetters, ['кие'])) {
                $listsLetter[count($listsLetter) - 1] = 'м';
            } elseif (in_array($twoLetters, ['ий', 'ле', 'ие', 'ай', 'эй'])) {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            } elseif (in_array($twoLetters, ['ый'])) {
                $listsLetter[count($listsLetter) - 1] = 'ому';
                unset($listsLetter[count($listsLetter) - 2]);
            } elseif (in_array($twoLetters, ['ии', 'ни'])) {
                $listsLetter[count($listsLetter) - 1] = 'ям';
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
        if (count($this->_words) > 1) {
            $getThis = &$this;
            $this->Accusative = implode($this->DelimiterInput, array_map(function ($item) use ($getThis) {
                return $getThis->setDeclareWordAccusative($item);
            }, $this->_words));
        } else {
            if($this->DelimiterInput != ' ') {
                $this->Accusative = $this->setDeclareWordAccusative($this->_words[0]) . $this->DelimiterInput;
            } else {
                $this->Accusative = $this->setDeclareWordAccusative($this->_words[0]);
            }
        }
    }

    private function setDeclareWordAccusative($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $treeLetters = [];
        $tlThree = null;
        if (isset($listsLetter[count($listsLetter) - 3])) {
            $treeLetters = implode('', [$listsLetter[count($listsLetter) - 3], $twoLetters]);
            $tlThree = $listsLetter[count($listsLetter) - 3];
        }

        if (in_array($lastLetter, ['а', 'я']) && !in_array($twoLetters, ['ья'])) {
            if(in_array($twoLetters, ['уа'])) {
                array_pop($listsLetter);
            } elseif ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'у';
            }  else {
                $listsLetter[count($listsLetter) - 1] = 'ю';
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if (
                (!in_array($twoLetters, ['ет', 'пр', 'ег', 'ус', 'ит', 'йх', 'ах', 'дж', 'ис', 'лл', 'са', 'лс', 'ик'])
                    && !in_array($treeLetters, ['янг', 'кан', 'ана', 'жан', 'нам', 'ьон', 'дан', 'дин', 'ден', 'тан'])) &&
                (in_array($twoLetters, ['ад', 'йн', 'мм', 'ам', 'ан', 'ин', 'он', 'ен'])
                    || in_array($lastLetter, ['с', 'т', 'р', 'г', 'в', 'л', 'м', 'к', 'х']))
            ) {
                $listsLetter[] = 'а';
            } elseif ($tlThree != 'ь' && in_array($treeLetters, ['вец'])) {
                unset($listsLetter[count($listsLetter) - 2]);
                $listsLetter[] = 'а';
            }
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);

            if (in_array($twoLetters, $listsCL)) {
                $listsLetter[count($listsLetter) - 1] = 'я';
            }
        } elseif (in_array($lastLetter, ['о', 'й', 'е'])) {
            $this->Accusative = implode('', $listsLetter);
            if (in_array($twoLetters, ['ий', 'ай', 'эй'])) {
                $listsLetter[count($listsLetter) - 1] = 'я';
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
        if (count($this->_words) > 1) {
            $getThis = &$this;
            $this->Instrumental = implode($this->DelimiterInput, array_map(function ($item) use ($getThis) {
                return $getThis->setDeclareWordInstrumental($item);
            }, $this->_words));
        } else {
            if($this->DelimiterInput != ' ') {
                $this->Instrumental = $this->setDeclareWordInstrumental($this->_words[0]) . $this->DelimiterInput;
            } else {
                $this->Instrumental = $this->setDeclareWordInstrumental($this->_words[0]);
            }
        }
    }

    private function setDeclareWordInstrumental($listsLetter)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $threeLetters = [];
        $tlThree = null;
        if (isset($listsLetter[count($listsLetter) - 3])) {
            $tlThree = $listsLetter[count($listsLetter) - 3];
            $threeLetters = implode('', [$tlThree, $twoLetters]);
        }

        $fourLetters = [];
        if (isset($listsLetter[count($listsLetter) - 4])) {
            $fourLetters = implode('', [$listsLetter[count($listsLetter) - 4], $threeLetters]);
        }

        if (in_array($twoLetters, ['би'])) {
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, ['а', 'я'])) {
            if(in_array($twoLetters, ['уа'])) {
                array_pop($listsLetter);
                $listsLetter[count($listsLetter) - 1] = 'ой';
            } elseif ($lastLetter == 'а') {
                if (in_array($twoLetters, ['жа']) && !in_array($fourLetters, ['уджа'])) {
                    $listsLetter[count($listsLetter) - 1] = 'ей';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'ой';
                }
            } elseif (in_array($twoLetters, ['ья'])) {
                $listsLetter[] = 'ми';
            } elseif ($lastLetter == 'я') {
                $listsLetter[count($listsLetter) - 1] = 'ей';
            }

        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($tlThree != 'ь' && in_array($twoLetters, ['ет', 'ец']) && !in_array($threeLetters, ['лет'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }
            if (in_array($threeLetters, ['вец'])) {
                array_push($listsLetter, 'ем');
            } else {

                if ((in_array($lastLetter, ['в']) || in_array($twoLetters, ['ин']))
                    && (!in_array($threeLetters, ['дин']) && !in_array($twoLetters, ['дж']))) {
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
            if (in_array($twoLetters, $listsCL) || in_array($threeLetters, ['ель'])) {
                array_push($listsLetter, 'ю');
            } else {
                $listsLetter[count($listsLetter) - 1] = 'ем';
            }

        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {

            if (in_array($twoLetters, ['ло', 'ве'])) {
                $listsLetter[count($listsLetter) - 1] = 'ом';
            } elseif (in_array($twoLetters, ['ые']) || in_array($threeLetters, ['кие'])) {
                $listsLetter[count($listsLetter) - 1] = 'ми';
            } elseif (in_array($twoLetters, ['ий', 'ле', 'ие', 'ай', 'эй'])) {
                $listsLetter[count($listsLetter) - 1] = 'ем';
            } elseif (in_array($twoLetters, ['ии', 'ни'])) {
                $listsLetter[count($listsLetter) - 1] = 'ями';
            } elseif (in_array($lastLetter, ['и'])) {
                $listsLetter[count($listsLetter) - 1] = 'ами';
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
        if (count($this->_words) > 1) {
            $getThis = &$this;
            $wordCount = 0;
            $this->Prepositional = implode($this->DelimiterInput, array_map(function ($item) use ($getThis, &$wordCount) {
                return $getThis->setDeclareWordPrepositional($item, $wordCount++);
            }, $this->_words));
        } else {
            if($this->DelimiterInput != ' ') {
                $this->Prepositional = $this->setDeclareWordPrepositional($this->_words[0]) . $this->DelimiterInput;
            } else {
                $this->Prepositional = $this->setDeclareWordPrepositional($this->_words[0]);
            }
        }
    }

    private function setDeclareWordPrepositional($listsLetter, $wordCount = 0)
    {
        $lastLetter = $listsLetter[count($listsLetter) - 1];
        $twoLetters = implode('', [$listsLetter[count($listsLetter) - 2], $lastLetter]);
        $firstLetter = strtolower($listsLetter[0]);
        $tlThree = null;
        $threeLetters = null;
        if (isset($listsLetter[count($listsLetter) - 3])) {
            $tlThree = $listsLetter[count($listsLetter) - 3];
            $threeLetters = implode('', [$tlThree, $twoLetters]);
        }


        if (in_array($twoLetters, ['би'])) {
            if ($wordCount == 0) {
                array_unshift($listsLetter, ' ');
                if (in_array($firstLetter, ['и', 'И', 'А', 'а', 'Э', 'э', 'о', 'О'])) {
                    array_unshift($listsLetter, 'об');
                } else {
                    array_unshift($listsLetter, 'о');
                }
            }
            return implode('', $listsLetter);
        }
        if (in_array($lastLetter, ['а', 'я'])) {
            if(in_array($twoLetters, ['уа'])) {
                array_pop($listsLetter);
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif ($lastLetter == 'а') {
                $listsLetter[count($listsLetter) - 1] = 'е';
            }
            if ($lastLetter == 'я') {
                if ($twoLetters == 'ля') {
                    $listsLetter[count($listsLetter) - 1] = 'е';
                } elseif (in_array($twoLetters, ['ья'])) {
                    $listsLetter[] = 'х';
                } else {
                    $listsLetter[count($listsLetter) - 1] = 'и';
                }
            }
        } elseif ($lastLetter != 'й' && in_array($lastLetter, $this->_consonantLetters)) {
            if ($tlThree != 'ь' && in_array($twoLetters, ['ет', 'ец']) && !in_array($threeLetters, ['лет'])) {
                unset($listsLetter[count($listsLetter) - 2]);
            }

            array_push($listsLetter, 'е');
        } elseif ($lastLetter == 'ь') {
            $items_consonantLetters = $this->_consonantLetters;
            unset($items_consonantLetters[array_search('л', $this->_consonantLetters)]);
            $listsCL = array_map(function ($item) use ($lastLetter) {
                return $item . $lastLetter;
            }, $items_consonantLetters);
            if (in_array($twoLetters, $listsCL) || in_array($threeLetters, ['ель'])) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } else {
                $listsLetter[count($listsLetter) - 1] = 'е';
            }

        } elseif (in_array($lastLetter, ['о', 'й', 'е', 'и'])) {
            if (in_array($twoLetters, ['ло', 'ле', 'ай', 'эй', 'ве'])) {
                $listsLetter[count($listsLetter) - 1] = 'е';
            } elseif ((in_array($lastLetter, ['е']) || in_array($threeLetters, ['кие'])) && !in_array($twoLetters, ['ее', 'ме', 'че', 'ий'])) {
                $listsLetter[count($listsLetter) - 1] = 'х';
            } elseif (in_array($twoLetters, ['ий', 'ие'])) {
                $listsLetter[count($listsLetter) - 1] = 'и';
            } elseif (in_array($twoLetters, ['ии', 'ни'])) {
                $listsLetter[count($listsLetter) - 1] = 'ях';
            } elseif (in_array($lastLetter, ['и'])) {
                $listsLetter[count($listsLetter) - 1] = 'ах';
            } elseif (in_array($lastLetter, ['й']) && !in_array($twoLetters, ['эй'])) {
                $listsLetter[count($listsLetter) - 1] = 'ом';
                unset($listsLetter[count($listsLetter) - 2]);
            }
        }

        if ($wordCount == 0) {
            array_unshift($listsLetter, ' ');
            if (in_array($firstLetter, ['и', 'И', 'А', 'а', 'Э', 'э', 'о', 'О'])) {
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

    /**
     * @return array
     */
    protected function getArraysLists()
    {
        $words = explode(' ', $this->_wordInput);
        $wordsDelimiter = explode(',', $this->_wordInput);
        $wordsDelimiterRe = explode('-', $this->_wordInput);

        if (count($wordsDelimiterRe) > 1) {
            $listsFirstLetter = \Letter::str_split_utf8($wordsDelimiterRe[0]);
            $twoEndLetters = implode('', [$listsFirstLetter[count($listsFirstLetter) - 2], $listsFirstLetter[count($listsFirstLetter) - 1]]);
            if(
                in_array(implode('', [$listsFirstLetter[0], $listsFirstLetter[1]]), ['ай', 'Ай'])
                && !in_array($listsFirstLetter[count($listsFirstLetter) - 1], ['о',  'и'])
                && in_array($twoEndLetters, ['ва', 'он'])
            ) {
                $this->DelimiterInput = '-' . $wordsDelimiterRe[1];
                return [$listsFirstLetter];
            }
        }

        if (count($wordsDelimiter) > 1) {
            $getter = $this->mapLetters($wordsDelimiter);
            if (count($getter) == 1) {
                return $getter;
            } else {
                $this->DelimiterInput = ',' . implode('', array_pop($getter));
                return [$getter[0]];
            }
        }


        if (count($words) > 1) {
            return $this->mapLetters($words);
        }
        return [$this->_listsLetters];
    }
}