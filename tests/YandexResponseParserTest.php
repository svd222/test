<?php
/**
 * Created by PhpStorm.
 *
 * User: svd
 *
 * @date: 29.09.16
 * @time: 14:29
 */
require './vendor/phpunit/phpunit/vendor/autoload.php';
require './ya/YandexResponseParser.php';

use svd\ya\YandexResponseParser;

class YandexResponseParserTest extends PHPUnit\Framework\TestCase {

    public $testStr1;

    public $testStr2;

    public $testStr3;

    public $testStr4;

    /**
     * Инициализирует состояние теста
     */
    protected function setUp()
    {
        $this->testStr1 = " Перевод на счет 41001000000000 Пароль: 0308 
Спишется 395,97р.
";

        $this->testStr2 = "Пароль: 0308
Спишется 395.97р.
Перевод на счет 41001000000000";

        $this->testStr3 = "
Спишется 395,97р.
Перевод на счет 41001000000000
Пароль: 0308";

        $this->testStr4 = "
Спишется 395,97р.
Перевод на счет 41001000000000
Пароль: 0308";
    }

    public function testData()
    {
        $yaParser = new YandexResponseParser();

        $res = $yaParser->parse($this->testStr1);
        $this->assertArrayHasKey('sum', $res);
        $this->assertNotEmpty($res['sum']);

        $res = $yaParser->parse($this->testStr1);
        $this->assertArrayHasKey('accountNumber', $res);
        $this->assertNotEmpty($res['accountNumber']);

        $res = $yaParser->parse($this->testStr1);
        $this->assertArrayHasKey('password', $res);
        $this->assertNotEmpty($res['password']);
    }

    /**
     * Тестирует сумму
     */
    public function testSum()
    {
        $yaParser = new YandexResponseParser();

        $res = $yaParser->parse($this->testStr1);
        $this->assertEquals(395.97, $res['sum']);

        $res = $yaParser->parse($this->testStr2);
        $this->assertEquals(395.97, $res['sum']);

        $res = $yaParser->parse($this->testStr3);
        $this->assertEquals(395.97, $res['sum']);

        $res = $yaParser->parse($this->testStr4);
        $this->assertEquals(395.97, $res['sum']);

    }

    /**
     * Тестирует номер счета
     */
    public function testAccountNumber()
    {
        $yaParser = new YandexResponseParser();

        $res = $yaParser->parse($this->testStr1);
        $this->assertEquals(41001000000000, $res['accountNumber']);

        $res = $yaParser->parse($this->testStr2);
        $this->assertEquals(41001000000000, $res['accountNumber']);

        $res = $yaParser->parse($this->testStr3);
        $this->assertEquals(41001000000000, $res['accountNumber']);

        $res = $yaParser->parse($this->testStr4);
        $this->assertEquals(41001000000000, $res['accountNumber']);
    }

    /**
     * Тестирует пароль
     */
    public function testPassword()
    {
        $yaParser = new YandexResponseParser();

        $res = $yaParser->parse($this->testStr1);
        $this->assertEquals('0308', $res['password']);

        $res = $yaParser->parse($this->testStr2);
        $this->assertEquals('0308', $res['password']);

        $res = $yaParser->parse($this->testStr3);
        $this->assertEquals('0308', $res['password']);

        $res = $yaParser->parse($this->testStr4);
        $this->assertEquals('0308', $res['password']);
    }
}
