<?php

/**
 * Class RakutenServiceTest
 * @property array $fixtureBooks
 */
class RakutenServiceTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->fixtureBooks = require dirname(__DIR__) . '/fixtures/rakuten/books.php';
    }

    public function testFind()
    {
        $service = new \App\Services\RakutenService();
        $expected = $this->fixtureBooks['valid'];
        $ret = $service->find([
            'isbn' => $expected['isbn']
        ]);
        $this->assertArrayHasKey('result', $ret);
        $actual = $ret['result'][0];
        $this->assertEquals($expected, $actual);
    }

    public function testShow()
    {
        $service = new \App\Services\RakutenService();
        $expected = $this->fixtureBooks['valid'];
        $actual = $service->show($expected['isbn']);
        $this->assertEquals($expected, $actual);
    }

    public function testPage()
    {
        $genre = '001005005';
        $service = new \App\Services\RakutenService();
        $first = $service->page(1, [
            'booksGenreId' => $genre
        ]);
        $second = $service->page($first['currentPage'] + 1, [
            'booksGenreId' => $genre
        ]);
        $this->assertEquals(2, intval($second['currentPage']));
    }

}