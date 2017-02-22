<?php

/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 12:33
 */
use Kind\Kind;

/**
 * A TestCase defines the fixture to run multiple tests.
 *
 * To define a TestCase
 *
 *   1) Implement a subclass of PHPUnit_Framework_TestCase.
 *   2) Define instance variables that store the state of the fixture.
 *   3) Initialize the fixture state by overriding setUp().
 *   4) Clean-up after a test by overriding tearDown().
 *
 * Each test runs in its own fixture so there can be no side effects
 * among test runs.
 *
 * Here is an example:
 *
 * <code>
 * <?php
 * class MathTest extends PHPUnit_Framework_TestCase
 * {
 *     public $value1;
 *     public $value2;
 *
 *     protected function setUp()
 *     {
 *         $this->value1 = 2;
 *         $this->value2 = 3;
 *     }
 * }
 * ?>
 * </code>
 *
 * For each test implement a method which interacts with the fixture.
 * Verify the expected results with assertions specified by calling
 * assert with a boolean.
 *
 * <code>
 * <?php
 * public function testPass()
 * {
 *     $this->assertTrue($this->value1 + $this->value2 == 5);
 * }
 * ?>
 * </code>
 *
 * @since Class available since Release 2.0.0
 */
class RussianTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataProvider_Types
     * @param $string
     * @param $returnType
     */
    public function test_getTypeKind($string, $returnType) {
        $this->assertEquals(Kind::init('Russian', $string)->getTypeKind(), $returnType, $string . ': Not Type');
    }

    public function dataProvider_Types() {
        return [
            ['паспорт', 1],
            ['журнал', 1],
            ['компьютер', 1],
            ['музей', 1],
            ['словарь', 1],
            ['мужчина', 1],
            ['юноша', 1],
            ['ребенок', 1],
            ['медвежонок', 1],
            ['дедушка', 1],
            ['дядя', 1],
            ['хлеб', 1],
            ['папа', 1],
            ['страна', 2],
            ['газета', 2],
            ['виза', 2],
            ['мама', 2],
            ['фамилия', 2],
            ['площадь', 2],
            ['земля', 2],
            ['лилия', 2],
            ['вишня', 2],
            ['вешалка', 2],
            ['доска', 2],
            ['письмо', 3],
            ['яблоко', 3],
            ['море', 3],
            ['лицо', 3],
            ['дерево', 3],
            ['кольцо', 3],
            ['керсло', 3],
            ['здание', 3],
            ['окно', 3],
            ['яйцо', 3],
            ['cолнце', 3],
            ['время', 3],
            ['знамя', 3],
        ];
    }
}