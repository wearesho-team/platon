<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;
use Wearesho\Bobra\Platon;
use GuzzleHttp;

/**
 * Class Client
 * @package Wearesho\Bobra\Platon\Credit
 */
class Client implements Credit\ClientInterface
{
    /** @var GuzzleHttp\ClientInterface */
    protected $guzzleClient;

    /** @var Platon\Config */
    protected $config;

    /** @var Response\Validator */
    protected $responseValidator;

    public function __construct(
        Platon\ConfigInterface $config,
        GuzzleHttp\ClientInterface $guzzleClient,
        Response\Validator $responseValidator
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
        $this->responseValidator = $responseValidator;
    }

    /**
     * @param Credit\TransferInterface $creditToCard
     * @return Response
     * @throws Exception
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function send(Credit\TransferInterface $creditToCard): Credit\Response
    {
        $this->validateCardToken($creditToCard->getCardToken());

        $params = [
            'client_key' => $this->config->getKey(),
            'action' => CreditToCardInterface::ACTION,
            'order_currency' => $creditToCard->getCurrency(),
            'order_description' => $creditToCard->getDescription(),
            'order_id' => $creditToCard->getId(),
            'order_amount' => number_format($creditToCard->getAmount(), 2, '.', ''),
            'card_token' => $creditToCard->getCardToken(),
        ];

        $this->appendHash($params);

        $response = $this->guzzleClient->request('post', '/p2p/index.php', [
            'base_uri' => $this->config->getBaseUrl(),
            'form_params' => $params,
        ]);

        $creditResponse = new Response(json_decode((string)$response->getBody(), true));

        $this->responseValidator->validate($creditResponse, $creditToCard);

        return $creditResponse;
    }

    public function getConfig(): Platon\ConfigInterface
    {
        return $this->config;
    }

    protected function validateCardToken(string $cardToken): void
    {
        if (!preg_match('/\w{32}/', $cardToken)) {
            throw new \InvalidArgumentException("Invalid card token");
        }
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
