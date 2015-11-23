<?php


namespace App\Services;

use App\ActiveResources\Rakuten;

class RakutenService
{

    /**
     * @return array
     */
    public function all()
    {
        $activeResource = new Rakuten();
        return $activeResource
            ->get()
            ->result();
    }

    /**
     * @param array $conditions
     * @return mixed
     */
    public function find(array $conditions)
    {
        $activeResource = new Rakuten();
        return $activeResource
            ->conditions($conditions)
            ->get()
            ->result();
    }

    /**
     * @param int $page
     * @param array $conditions
     * @return mixed
     */
    public function page($page, array $conditions)
    {
        if (empty($page) || !ctype_digit((string)$page)) {
            $page = 1;
        }
        $conditions['page'] = $page;
        return $this->find($conditions);
    }

    /**
     * @param string $isbn
     * @return array|null
     */
    public function show($isbn)
    {
        $activeResource = new Rakuten;
        $ret = $activeResource
            ->conditions(['isbn' => $isbn])
            ->get()
            ->result();
        if (empty($ret['result'][0])) {
            return $ret;
        }
        return $ret['result'][0];
    }

}