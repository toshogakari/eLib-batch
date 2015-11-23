<?php

class CategoryParserTest extends PHPUnit_Framework_TestCase
{
    public function testJava()
    {
        $parser = new App\Parser\CategoryParser();
        $this->assertTrue($parser->parse('Java入門書'));
        $this->assertFalse($parser->parse('JavaScript入門書'));
    }

    public function testJavaScript()
    {

    }
}