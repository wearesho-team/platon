<?php

namespace Wearesho\Bobra\Platon\Notification;

/**
 * Class Payment
 * @package Wearesho\Bobra\Platon\Notification
 */
class Payment implements PaymentInterface, HasBody
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $key;

    /** @var string */
    protected $orderId;

    /** @var float */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $status;

    /** @var string */
    protected $card;

    /** @var \DateTimeInterface */
    protected $date;

    /** @var array */
    protected $data;

    /** @var string|null */
    protected $rcToken;

    /** @var array */
    protected $body;

    public function __construct(
        string $id,
        string $key,
        string $orderId,
        float $amount,
        string $currency,
        string $status,
        string $card,
        \DateTimeInterface $date,
        string $rcToken = null,
        array $data = [],
        array $body = []
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->status = $status;
        $this->card = $card;
        $this->date = $date;
        $this->rcToken = $rcToken;
        $this->data = $data;
        $this->body = $body;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCard(): string
    {
        return $this->card;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getRcToken(): ?string
    {
        return $this->rcToken;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
