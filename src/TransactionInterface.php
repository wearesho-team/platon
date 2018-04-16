<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

/**
 * Interface TransactionInterface
 * @package Wearesho\Bobra\Platon
 */
interface TransactionInterface extends Payments\TransactionInterface
{
    public function getFormId(): ?string;
}
