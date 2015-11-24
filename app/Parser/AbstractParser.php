<?php

namespace App\Parser;

abstract class AbstractParser
{
    /**
     * @var array
     */
    protected $parseList;

    /**
     * constructor.
     */
    public function __construct()
    {
        if (empty($this->parseList) || !is_array($this->parseList)) {
            throw new \UnexpectedValueException('invalid property in parseList');
        }
    }

    /**
     * @param $text
     * @return bool|int|string
     */
    public function parse($text)
    {
        foreach ($this->parseList as $key => $regex) {
            if ($this->chime($text, $regex)) {
                return $key;
            }
        }
        return false;
    }

    /**
     * @param $text
     * @param $regex
     * @return bool
     */
    protected function chime($text, $regex)
    {
        if (!is_array($regex)) {
            return !!preg_match($regex, $text);
        }
        foreach ($regex as $re) {
            echo $re, $text, PHP_EOL;
            if (preg_match($re, $text)) {
                return true;
            }
        }
        return false;
    }
}