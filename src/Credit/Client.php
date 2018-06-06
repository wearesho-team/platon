<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Platon;
use GuzzleHttp;

/**
 * Class Client
 * @package Wearesho\Bobra\Platon\Credit
 */
class Client
{
    /** @var GuzzleHttp\ClientInterface */
    protected $guzzleClient;

    /** @var Platon\Config */
    protected $config;

    public function __construct(Platon\ConfigInterface $config, GuzzleHttp\ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
    }

    /**
     * @param CreditToCardInterface $creditToCard
     * @throws GuzzleHttp\Exception\GuzzleException
     * @return Response
     */
    public function send(CreditToCardInterface $creditToCard): Response
    {
        $params = [
            'client_key' => $this->config->getKey(),
            'action' => $creditToCard::ACTION,
            'order_currency' => $creditToCard->getCurrency(),
            'order_description' => $creditToCard->getDescription(),
            'order_id' => $creditToCard->getId(),
            'order_amount' => $creditToCard->getAmount(),
            'card_token' => $creditToCard->getCardToken(),
        ];

        $this->appendHash($params);

        $response = $this->guzzleClient->request('post', '/p2p/index.php', [
            'base_uri' => $this->config->getBaseUrl(),
            'form_params' => $params,
        ]);

        return new Response(json_decode((string)$response->getBody(), true));
    }

    public function getConfig(): Platon\ConfigInterface
    {
        return $this->config;
    }

    protected function appendHash(array &$data): void
    {
        $data['hash'] = md5(strtoupper(
            $data['order_id']
            . $data['order_amount']
            . $data['order_description']
            . $data['card_token']
            . $this->config->getPass()
        ));
    }
}
