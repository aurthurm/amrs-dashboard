<?php

namespace App\Service;
interface CommonServiceInterface
{
    public function doCommonThing();
}

class CommonService implements CommonServiceInterface
{
    public function doCommonThing()
    {
        echo 'do awesome thing !!!';
    }
}

?>