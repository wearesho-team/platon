<?php

namespace Wearesho\Bobra\Platon\Credit;

interface HasExpireDate
{
    public function getExpireMonth(): int;
    public function getExpireYear(): int;
}
