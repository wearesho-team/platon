<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

interface TransactionInterface extends Payments\TransactionInterface
{
    public function getFormId(): ?string;
}
