<?php


class CategoryParserTest extends PHPUnit_Framework_TestCase
{

    public function testJava()
    {
        $this->__('Java', [
            ['==', 'Java入門書'],
            ['!=', 'JavaScript入門書']
        ]);
    }

    public function testJavaScript()
    {
        $this->__('JavaScript', [
            ['==', 'JavaScript(2)'],
            ['==', 'jQuery入門(2)'],
            ['!=', 'Java入門書']

        ]);
    }

    public function testRuby()
    {
        $this->__('Ruby', [
            ['==', 'Ruby入門'],
            ['==', 'Rails入門']
        ]);
    }

    public function testSql()
    {
        $this->__('SQL', [
            ['==', 'MySQL入門'],
            ['==', 'SQL Server入門']
        ]);
    }

    public function testGo()
    {
        $this->__('Go', [
            ['==', 'GoLanguage入門'],
            ['==', 'Google Go 機械学習入門']
        ]);
    }

    private function __($expect, array $actual)
    {
        $parser = new \App\Parser\CategoryParser();
        foreach ($actual as $v) {
            $operation = $v[0];
            $text = $v[1];
            if ($operation === '==') {
                $this->assertEquals($expect, $parser->parse($text));
            } else if ($operation === '!=') {
                $this->assertNotEquals($expect, $parser->parse($text));
            }
        }
    }

}