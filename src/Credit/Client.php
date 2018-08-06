<?php

namespace Wearesho\Bobra\Platon\Credit;

use Nekman\LuhnAlgorithm;
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

    /** @var LuhnAlgorithm\Contract\LuhnAlgorithmInterface */
    protected $luhn;

    public function __construct(
        Platon\ConfigInterface $config,
        GuzzleHttp\ClientInterface $guzzleClient,
        Response\Validator $responseValidator
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
        $this->responseValidator = $responseValidator;
        $this->luhn = LuhnAlgorithm\LuhnAlgorithmFactory::create();
    }

    /**
     * @param Credit\TransferInterface $creditToCard
     * @return Response
     * @throws Exception
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function send(Credit\TransferInterface $creditToCard): Credit\Response
    {
        $response = $this->guzzleClient->request('post', '/p2p/index.php', [
            'base_uri' => $this->config->getBaseUrl(),
            'form_params' => $this->generateParams($creditToCard),
        ]);

        $creditResponse = new Response(json_decode((string)$response->getBody(), true));

        $this->responseValidator->validate($creditResponse, $creditToCard);

        return $creditResponse;
    }

    public function getConfig(): Platon\ConfigInterface
    {
        return $this->config;
    }

    protected function generateParams(Credit\TransferInterface $creditToCard): array
    {
        $params = [
            'client_key' => $this->config->getKey(),
            'order_currency' => $creditToCard->getCurrency(),
            'order_description' => $creditToCard->getDescription(),
            'order_id' => $creditToCard->getId(),
            'order_amount' => number_format($creditToCard->getAmount(), 2, '.', ''),
        ];

        $token = $creditToCard->getCardToken();

        if ($this->isCardNumber($token)) {
            $params['action'] = CreditToCardInterface::ACTION_CARD;
            $params['card_number'] = $token;
            $this->appendCardHash($params);

            if ($creditToCard instanceof HasExpireDate) {
                $params['card_exp_month'] = $creditToCard->getExpireMonth();
                $params['card_exp_year'] = $creditToCard->getExpireYear();
            }
        } else {
            $this->validateCardToken($token);

            $params['action'] = CreditToCardInterface::ACTION_TOKEN;
            $params['card_token'] = $token;
            $this->appendTokenHash($params);
        }

        return $params;
    }

    protected function isCardNumber(string $token): bool
    {
        return preg_match('/\d{16}/', $token) && $this->luhn->isValid(LuhnAlgorithm\Number::fromString($token));
    }

    protected function validateCardToken(string $cardToken): void
    {
        if (!preg_match('/\w{32}/', $cardToken)) {
            throw new \InvalidArgumentException("Invalid card token");
        }
    }

    protected function appendTokenHash(array &$data): void
    {
        $data['hash'] = md5(strtoupper(
            $data['order_id']
            . $data['order_amount']
            . $data['order_description']
            . $data['card_token']
            . $this->config->getPass()
        ));
    }

    protected function appendCardHash(array &$data): void
    {
        $data['hash'] = md5(
            strtoupper(
                $this->config->getPass()
                . strrev(
                    substr($data['card_number'], 0, 6) . substr($data['card_number'], -4)
                )
            )
        );
    }
}
