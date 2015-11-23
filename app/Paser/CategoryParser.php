<?php

namespace App\Parser;

class CategoryParser extends AbstractParser
{
    protected $parseList = [
        'Java'       => '/Java(?!(Script))/i',
        'JavaScript' => [
            '/JavaScript/i',
            '/jQuery/i'
        ],
        'PHP'  => '/PHP/i',
        'Ruby' => [
            '/Ruby/i',
            '/Rails/i'
        ],
        'C' => [
            '/C(?!(++|#))/i',
            '/C言語/i'
        ],
        'C#'  => '/C#/i',
        'C++' => '/C++/i',
        'SQL' => '/SQL/i'
    ];

}