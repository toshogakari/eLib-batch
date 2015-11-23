<?php

namespace App\ActiveResources\Results;

use App\ActiveResources\Results\Parts\ParseResult;

class RakutenResult extends AbstractResult
{
    use ParseResult;

    protected $parseColumns = [
        'title'         => [
            'variableType' => 'string'
        ],
        'isbn'          => [
            'variableType' => 'integer'
        ],
        'author'        => [
            'variableType' => 'string'
        ],
        'salesDate'     => [
            'columnName'   => 'sales_at',
            'variableType' => 'dateInJapanese'
        ],
        'itemCaption'   => [
            'columnName'   => 'description',
            'variableType' => 'string'
        ],
        'largeImageUrl' => [
            'columnName'   => 'pc_image_url',
            'variableType' => 'string'
        ],
        'smallImageUrl' => [
            'columnName'   => 'mb_image_url',
            'variableType' => 'string'
        ]
    ];

    /**
     * @return array|null
     */
    public function result()
    {
        $res = json_decode($this->response->getBody(), true);
        if (empty($res['Items'])) {
            return null;
        }
        $ret = [
            'maxPage'     => $res['pageCount'],
            'currentPage' => $res['page'],
            'itemCount'   => count($res['Items']),
            'result'      => []
        ];
        foreach ($res['Items'] as $item) {
            $ret['result'][] = $this->parse($item['Item']);
        }
        return $ret;
    }

}