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

    public function __construct(Platon\ConfigInterface $config, GuzzleHttp\ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
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

        try {
            $response = $this->guzzleClient->request('post', '/p2p/index.php', [
                'base_uri' => $this->config->getBaseUrl(),
                'form_params' => $params,
            ]);
        } catch (GuzzleHttp\Exception\RequestException $exception) {
            $body = $exception->getResponse()->getBody()->__toString();
            $response = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE
                || !array_key_exists('result', $response)
                || !array_key_exists('error_message', $response)
            ) {
                throw $exception;
            }

            if ($response['error_message'] === 'Duplicate request') {
                throw new Platon\Credit\Exceptions\DuplicatedTransfer($creditToCard, 0, $exception);
            }

            if ($response['error_message'] === '2 9852 Invalid card') {
                throw new Platon\Credit\Exceptions\InvalidCardToken($creditToCard, 0, $exception);
            }

            throw new Exception($creditToCard, $response['error_message'], 0, $exception);
        }

        return new Response(json_decode((string)$response->getBody(), true));
    }

    public function getConfig(): Platon\ConfigInterface
    {
        return $this->config;
    }

    protected function validateCardToken(string $cardToken): void
    {
        if (!preg_match('/\w{32}/', $cardToken)) {
            throw new \InvalidArgumentException("Invalid Card Token");
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
