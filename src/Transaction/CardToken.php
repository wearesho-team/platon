<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Transaction;

/**
 * Interface CardToken
 * @package Wearesho\Bobra\Platon\Transaction
 */
interface CardToken
{
    public function getCardToken(): ?string;
}
