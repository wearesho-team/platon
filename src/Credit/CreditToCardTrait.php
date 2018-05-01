<?php

namespace Wearesho\Bobra\Platon\Credit;

/**
 * Trait CreditToCardTrait
 * @package Wearesho\Bobra\Platon\Credit
 */
trait CreditToCardTrait
{
    /** @var string */
    private $cardToken;

    /** @var string */
    protected $id;

    /** @var int */
    protected $amount;

    /** @var string|null */
    protected $currency;

    /** @var string|null */
    protected $description;

    /**
     * @inheritdoc
     */
    public function getCardToken(): string
    {
        return $this->cardToken;
    }

    /**
     * @inheritdoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @inheritdoc
     */
    public function getCurrency(): string
    {
        return $this->currency ?? 'UAH';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    protected function setCardToken(string $cardToken): self
    {
        if (!preg_match('/\w{32}/', $cardToken)) {
            throw new \InvalidArgumentException("Invalid Card Token");
        }

        $this->cardToken = $cardToken;

        return $this;
    }
}
