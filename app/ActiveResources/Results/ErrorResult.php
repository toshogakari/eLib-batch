<?php

namespace App\ActiveResources\Results;

class ErrorResult implements InterfaceResult
{
    /**
     * @return array
     * @throws \RuntimeException
     */
    public function result()
    {
        return null;
    }
}