<?php

namespace Wearesho\Bobra\Platon\Notification\Payment;

/**
 * Interface Status
 * @package Wearesho\Bobra\Platon\Notification\Payment
 */
interface Status
{
    public const SALE = 'SALE';
    public const REFUND = 'REFUND';
    public const CHARGEBACK = 'CHARGEBACK';
}
