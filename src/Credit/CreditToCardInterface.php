<?php

namespace Wearesho\Bobra\Platon\Credit;

/**
 * Interface CreditToCardInterface
 * @package Wearesho\Bobra\Platon\Credit
 */
interface CreditToCardInterface
{
    public const ACTION = 'CREDIT2CARDTOKEN';

    /**
     * Card token received after card verification
     *
     * @return string
     */
    public function getCardToken(): string;

    /**
     * Credit ID. It have to be unique for each credit.
     * Used for preventing double-sending funds
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Funds amount to be transferred to clients credit card.
     *
     * @return int
     */
    public function getAmount(): int;


    /**
     * 3-letter currency code
     *
     * @return string
     */
    public function getCurrency(): string;

    /**
     * Operation description
     *
     * @return string|null
     */
    public function getDescription(): ?string;
}
