<?php

namespace App\ActiveResources\Results\Parts;

use App\ActiveResources\Exceptions\InvalidCastException;

trait ParseResult
{

    /**
     * @param array $item
     * @return array
     */
    protected function parse(array $item)
    {
        $ret = [];
        if (empty($this->parseColumns)) {
            throw new \RuntimeException('bad empty, parse columns');
        }
        foreach ($this->parseColumns as $key => $column) {
            if (!array_key_exists($key, $item)) {
                $ret[$this->columnName($key, $column)] = null;
                continue;
            }
            $val = $item[$key];
            if (isset($column['variableType'])) {
                $val = $this->cast($val, $column['variableType']);
            }
            $ret[$this->columnName($key, $column)] = $val;
        }
        return $ret;
    }

    /**
     * @param $val
     * @return int
     */
    protected function toInteger($val)
    {
        return intval($val);
    }

    /**
     * @param $val
     * @return string
     */
    protected function toString($val)
    {
        return strval($val);
    }

    /**
     * @param $val
     * @return bool|string
     */
    protected function toDate($val)
    {
        return date('Y-m-d', strtotime($val));
    }

    /**
     * @param $val
     * @return string
     */
    protected function toDateInJapanese($val)
    {
        $formats = ['Y年m月d日' => 'Y-m-d', 'Y年m月' => 'Y-m-01'];
        foreach ($formats as $beforeFormat => $afterFormat) {
            $date = \DateTime::createFromFormat($beforeFormat, $val);
            if (!$date) {
                continue;
            }
            return $date->format($afterFormat);
        }
        return null;
    }

    /**
     * @param $val
     * @return bool|string
     */
    protected function toDateTime($val)
    {
        return date('Y-m-d H:i:s', strtotime($val));
    }

    /**
     * @param $val
     * @return string
     */
    protected function toDateTimeInJapanese($val)
    {
        return \DateTime::createFromFormat('Y年m月d日H時i分s秒', $val)
            ->format('Y-m-d H:i:s');
    }

    /**
     * @param $key
     * @param $column
     * @return string
     */
    private function columnName($key, $column)
    {
        return isset($column['columnName']) ?
            $column['columnName'] : $key;
    }

    /**
     * @param $val
     * @param $variableType
     * @return mixed
     */
    private function cast($val, $variableType)
    {
        $method = sprintf('to%s', ucfirst($variableType));
        if (method_exists($this, $method)) {
            return $this->$method($val);
        }
        throw new InvalidCastException('invalid cast => ' . $method);
    }

}