<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 23.02.17
 * Time: 13:31
 */

namespace Declension;


use PHPUnit_Framework_TestCase;

class RussianTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataProvider_getDative
     * @param $string
     * @param $returnType
     */
    public function test_getDative($string, $returnType) {
        $this->assertEquals(Declension::init('Russian', $string)->getDative(), $returnType, $string . ' != ' . $returnType);
    }
    public function dataProvider_getDative() {
        return [
            ['Германия','Германии'],
            ['Египет','Египту'],
            ['Кипр','Кипру'],
            ['Куба','Кубе'],
            ['Испания','Испании'],
            ['Греция','Греции'],
            ['Шри-Ланка','Шри-Ланке'],
            ['Израиль','Израилю'],
            ['Вьетнам','Вьетнаму'],
            ['Италия','Италии'],
            ['Турция','Турции'],
            ['Андорра','Андорре'],
            ['Шарм-эль-Шейх','Шарм-эль-Шейху'],
            ['Хургада','Хургаде'],
            ['Доминикана','Доминикане'],
            ['Венеция','Венеции'],
            ['Австрия','Австрии'],
            ['Бад Гаштайн','Баду Гаштайну'],
            ['Бад Хофгаштайн','Баду Хофгаштайну'],
            ['Заальбах','Заальбаху'],
            ['Зельден','Зельдену'],
            ['Ишгль','Ишглю'],
            ['Капрун','Капруну'],
            ['Хинтерглемм','Хинтерглемму'],
            ['Цель-ам-Зее','Цель-ам-Зее'],
            ['Болгария','Болгарии'],
            ['Албена','Албене'],
            ['Банско','Банско'],
            ['Боровец','Боровцу'],
            ['Бургас','Бургасу'],
            ['Варна','Варне'],
            ['Золотые пески','Золотым пескам'],
            ['Пампорово','Пампорово'],
            ['Созополь','Созополю'],
            ['Солнечный берег','Солнечному берегу'],
            ['София','Софии'],
            ['Венгрия','Венгрии'],
            ['Будапешт','Будапешту'],
            ['Хевиз','Хевизу'],
            ['Эгер','Эгеру'],
            ['Дананг','Данангу'],
            ['Фантьет','Фантьету'],

        ];
    }


    /**
     * @test
     * @dataProvider dataProvider_getGenitive()
     * @param $string
     * @param $returnType
     */
    public function test_getGenitive($string, $returnType) {
        $this->assertEquals(Declension::init('Russian', $string)->getGenitive(), $returnType, $string . ' != ' . $returnType);
    }

    public function dataProvider_getGenitive() {
        return [
            ['Германия','Германии'],
            ['Египет','Египта'],
            ['Кипр','Кипра'],
            ['Куба','Кубы'],
            ['Испания','Испании'],
            ['Греция','Греции'],
            ['Шри-Ланка','Шри-Ланки'],
            ['Израиль','Израиля'],
            ['Вьетнам','Вьетнама'],
            ['Италия','Италии'],
            ['Турция','Турции'],
            ['Андорра','Андорры'],
            ['Шарм-эль-Шейх','Шарм-эль-Шейха'],
            ['Хургада','Хургады'],
            ['Доминикана','Доминиканы'],
            ['Венеция','Венеции'],
            ['Австрия','Австрии'],
            ['Бад Гаштайн','Бада Гаштайна'],
            ['Бад Хофгаштайн','Бада Хофгаштайна'],
            ['Заальбах','Заальбаха'],
            ['Зельден','Зельдена'],
            ['Ишгль','Ишгля'],
            ['Капрун','Капруна'],
            ['Хинтерглемм','Хинтерглемма'],
            ['Цель-ам-Зее','Цель-ам-Зее'],
            ['Болгария','Болгарии'],
            ['Албена','Албены'],
            ['Банско','Банско'],
            ['Боровец','Боровца'],
            ['Бургас','Бургаса'],
            ['Варна','Варны'],
            ['Золотые пески','Золотых песков'],
            ['Пампорово','Пампорово'],
            ['Созополь','Созополя'],
            ['Солнечный берег','Солнечного берега'],
            ['София','Софии'],
            ['Венгрия','Венгрии'],
            ['Будапешт','Будапешта'],
            ['Хевиз','Хевиза'],
            ['Эгер','Эгера'],
            ['Дананг','Дананга'],
            ['Фантьет','Фантьета'],
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_getAccusative()
     * @param $string
     * @param $returnType
     */
    public function test_getAccusative($string, $returnType) {
        $this->assertEquals(Declension::init('Russian', $string)->getAccusative(), $returnType, $string . ' != ' . $returnType);
    }

    public function dataProvider_getAccusative() {
        return [
            ['Германия','Германию'],
            ['Египет','Египет'],
            ['Кипр','Кипр'],
            ['Куба','Кубу'],
            ['Испания','Испанию'],
            ['Греция','Грецию'],
            ['Шри-Ланка','Шри-Ланку'],
            ['Израиль','Израиль'],
            ['Вьетнам','Вьетнам'],
            ['Италия','Италию'],
            ['Турция','Турцию'],
            ['Андорра','Андорру'],
            ['Шарм-эль-Шейх','Шарм-эль-Шейх'],
            ['Хургада','Хургаду'],
            ['Доминикана','Доминикану'],
            ['Венеция','Венецию'],
            ['Австрия','Австрию'],
            ['Бад Гаштайн','Бада Гаштайна'],
            ['Бад Хофгаштайн','Бада Хофгаштайна'],
            ['Заальбах','Заальбах'],
            ['Зельден','Зельден'],
            ['Ишгль','Ишгль'],
            ['Капрун','Капрун'],
            ['Хинтерглемм','Хинтерглемма'],
            ['Цель-ам-Зее','Цель-ам-Зее'],
            ['Болгария','Болгарию'],
            ['Албена','Албену'],
            ['Банско','Банско'],
            ['Боровец','Боровца'],
            ['Бургас','Бургаса'],
            ['Варна','Варну'],
            ['Золотые пески','Золотые пески'],
            ['Пампорово','Пампорово'],
            ['Созополь','Созополь'],
            ['Солнечный берег','Солнечный берег'],
            ['София','Софию'],
            ['Венгрия','Венгрию'],
            ['Будапешт','Будапешта'],
            ['Хевиз','Хевиз'],
            ['Эгер','Эгера'],
            ['Дананг','Дананга'],
            ['Фантьет','Фантьет'],

        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_getInstrumental()
     * @param $string
     * @param $returnType
     */
    public function test_getInstrumental($string, $returnType) {
        $this->assertEquals(Declension::init('Russian', $string)->getInstrumental(), $returnType, $string . ' != ' . $returnType);
    }

    public function dataProvider_getInstrumental() {
        return [
            ['Германия','Германией'],
            ['Египет','Египтом'],
            ['Кипр','Кипром'],
            ['Куба','Кубой'],
            ['Испания','Испанией'],
            ['Греция','Грецией'],
            ['Шри-Ланка','Шри-Ланкой'],
            ['Израиль','Израилем'],
            ['Вьетнам','Вьетнамом'],
            ['Италия','Италией'],
            ['Турция','Турцией'],
            ['Андорра','Андоррой'],
            ['Шарм-эль-Шейх','Шарм-эль-Шейхом'],
            ['Хургада','Хургадой'],
            ['Доминикана','Доминиканой'],
            ['Венеция','Венецией'],
            ['Австрия','Австрией'],
            ['Бад Гаштайн','Бадом Гаштайном'],
            ['Бад Хофгаштайн','Бадом Хофгаштайном'],
            ['Заальбах','Заальбахом'],
            ['Зельден','Зельденом'],
            ['Ишгль','Ишглем'],
            ['Капрун','Капруном'],
            ['Хинтерглемм','Хинтерглеммом'],
            ['Цель-ам-Зее','Цель-ам-Зеей'],
            ['Болгария','Болгарией'],
            ['Албена','Албеной'],
            ['Банско','Банско'],
            ['Боровец','Боровцем'],
            ['Бургас','Бургасом'],
            ['Варна','Варной'],
            ['Золотые пески','Золотыми песками'],
            ['Пампорово','Пампорово'],
            ['Созополь','Созополем'],
            ['Солнечный берег','Солнечным берегом'],
            ['София','Софией'],
            ['Венгрия','Венгрией'],
            ['Будапешт','Будапештом'],
            ['Хевиз','Хевизом'],
            ['Эгер','Эгером'],
            ['Дананг','Данангом'],
            ['Фантьет','Фантьетом'],
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_getPrepositional()
     * @param $string
     * @param $returnType
     */
    public function test_getPrepositional($string, $returnType) {
        $this->assertEquals(Declension::init('Russian', $string)->getPrepositional(), $returnType, $string . ' != ' . $returnType);
    }

    public function dataProvider_getPrepositional() {
        return [
            ['Германия','о Германии'],
            ['Египет','о Египте'],
            ['Кипр','о Кипре'],
            ['Куба','о Кубе'],
            ['Испания','об Испании'],
            ['Греция','о Греции'],
            ['Шри-Ланка','о Шри-Ланке'],
            ['Израиль','об Израиле'],
            ['Вьетнам','о Вьетнаме'],
            ['Италия','об Италии'],
            ['Турция','о Турции'],
            ['Андорра','об Андорре'],
            ['Шарм-эль-Шейх','о Шарм-эль-Шейхе'],
            ['Хургада','о Хургаде'],
            ['Доминикана','о Доминикане'],
            ['Венеция','о Венеции'],
            ['Австрия','об Австрии'],
            ['Бад Гаштайн','о Баде Гаштайне'],
            ['Бад Хофгаштайн','о Баде Хофгаштайне'],
            ['Заальбах','о Заальбахе'],
            ['Зельден','о Зельдене'],
            ['Ишгль','об Ишгле'],
            ['Капрун','о Капруне'],
            ['Хинтерглемм','о Хинтерглемме'],
            ['Цель-ам-Зее','о Цель-ам-Зее'],
            ['Болгария','о Болгарии'],
            ['Албена','об Албене'],
            ['Банско','о Банско'],
            ['Боровец','о Боровце'],
            ['Бургас','о Бургасе'],
            ['Варна','о Варне'],
            ['Золотые пески','о Золотых песках'],
            ['Пампорово','о Пампорово'],
            ['Созополь','о Созополе'],
            ['Солнечный берег','о Солнечном береге'],
            ['София','о Софии'],
            ['Венгрия','о Венгрии'],
            ['Будапешт','о Будапеште'],
            ['Хевиз','о Хевизе'],
            ['Эгер','об Эгере'],
            ['Дананг','о Дананге'],
            ['Фантьет','о Фантьете'],
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_filesTest()
     * @param $Nominative
     * @param $Genitive
     * @param $Dative
     * @param $Accusative
     * @param $Instrumental
     * @param $Prepositional
     */
    public function test_filesTest($Nominative, $Genitive, $Dative, $Accusative, $Instrumental, $Prepositional) {
        $test = Declension::init('Russian', $Nominative);
        $this->assertEquals($test->getResult(), [
            'Nominative' => $Nominative,
            'Genitive' => $Genitive,
            'Dative' => $Dative,
//            'Accusative' => $Accusative,
            'Instrumental' => $Instrumental,
            'Prepositional' => $Prepositional
        ], 'Nominative: ' . $Nominative);
    }

    public function dataProvider_filesTest() {
        $pathFile = realpath('') . DIRECTORY_SEPARATOR . 'Declension' . DIRECTORY_SEPARATOR . 'morfers_test.json';
        $lists = json_decode(file_get_contents($pathFile), true);
        return $lists;
    }
}