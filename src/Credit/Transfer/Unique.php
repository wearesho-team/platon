<?php

namespace Wearesho\Bobra\Platon\Credit\Transfer;

use Wearesho\Bobra\Payments\Credit\TransferInterface;

/**
 * Interface Unique
 * @package Wearesho\Bobra\Platon\Credit\Transfer
 *
 * This interface may be implemented by
 * @see TransferInterface implementation
 * to send queries to /p2p-unq/ instead of /p2p/
 * when transfering funds
 */
interface Unique
{
}
