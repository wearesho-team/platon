<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\DirectDebit;

use GuzzleHttp;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Bobra\Platon;

readonly class Client
{
    private const string ENDPOINT_CHARGE = '/post-unq/';

    public function __construct(
        private Platon\ConfigInterface $config,
        private GuzzleHttp\ClientInterface $httpClient,
    ) {
    }

    /**
     * @throws Exception
     */
    public function charge(Request $request): array
    {
        $ext = [];
        foreach ($request->ext as $extKey => $extValue) {
            $ext[$extKey + 1] = $extValue;
        }
        $ext[3] = 'recurring';

        $requestData = [
            'action' => 'SALE',
            'client_key' => $this->config->getKey(),
            'order_id' => $request->orderId,
            'order_amount' => $request->amount,
            'order_currency' => 'UAH',
            'order_description' => $request->description,
            'card_token' => $request->cardToken,
            'payer_email' => $request->email,
            'payer_phone' => $request->phone,
            'term_url_3ds' => $request->termUrl,
            'hash' => $request->hash($this->config->getPass()),
        ];
        foreach ($ext as $extKey => $extValue) {
            $requestData['ext' . $extKey] = $extValue;
        }
        return $this->request('POST', self::ENDPOINT_CHARGE, $requestData);
    }

    /**
     * @throws Exception
     */
    private function request(string $method, string $endpoint, array $body): array
    {
        $url = Platon\ConfigInterface::PAYMENT_URL . $endpoint;
        try {
            $response = $this->httpClient->request($method, $url, [
                GuzzleHttp\RequestOptions::JSON => $body,
            ]);
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            if ($e instanceof GuzzleHttp\Exception\BadResponseException) {
                $this->handleBadResponse($e->getResponse());
            }

            throw new Exception(
                "DirectDebit Request {$method} /{$endpoint} failed: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }

        $data = $this->decodeResponse($response);
        if (!array_key_exists('result', $data)) {
            throw new Exception("Invalid DirectDebit BadResponse contents: missing result key", -401);
        }
        if ($data['result'] === 'ERROR') {
            $this->handleError($data);
        }
        return $data;
    }

    private function handleBadResponse(ResponseInterface $response): void
    {
        $data = $this->decodeResponse($response);
        if (!array_key_exists('result', $data)) {
            throw new Exception("Invalid DirectDebit BadResponse contents: missing result key", -101);
        }
        if ($data['result'] !== 'ERROR') {
            throw new Exception(
                "Invalid DirectDebit BadResponse contents: result is " . $data['result'] . ', ERROR expected',
                -201
            );
        }
        $this->handleError($data);
    }

    private function handleError(array $responseData): void
    {
        if (!array_key_exists('error_message', $responseData)) {
            throw new Exception("Invalid DirectDebit BadResponse contents: missing error_message key", -101);
        }
        $errorMessage = $responseData['error_message'];
        if (in_array($errorMessage, InvalidCardException::getMessages())) {
            throw new InvalidCardException("Invalid CardToken: " . $errorMessage, -301);
        }
        throw new Exception("Failed DirectDebit transaction: " . $errorMessage, -302);
    }

    private function decodeResponse(ResponseInterface $response): array
    {
        try {
            return json_decode($response->getBody()->__toString(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new Exception(
                "Failed to decode DirectDebit response: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
