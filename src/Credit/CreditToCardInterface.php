<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

/**
 * Interface CreditToCardInterface
 * @package Wearesho\Bobra\Platon\Credit
 */
interface CreditToCardInterface extends Credit\TransferInterface
{
    public const ACTION = 'CREDIT2CARDTOKEN';
}
