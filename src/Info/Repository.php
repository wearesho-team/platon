<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Info;

use Carbon\Carbon;
use GuzzleHttp;

/**
 * Class Repository
 * @package Wearesho\Bobra\Platon\Info
 */
class Repository
{
    /** @var ConfigInterface */
    protected $config;

    /** @var GuzzleHttp\ClientInterface */
    protected $client;

    public function __construct(
        ConfigInterface $config,
        GuzzleHttp\ClientInterface $client
    ) {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Response[]
     * @throws GuzzleHttp\Exception\GuzzleException
     * @throws InvalidResponseException
     */
    public function get(\DateTimeInterface $date = null): array
    {
        $baseUrl = \rtrim($this->config->getBaseUrl(), '/');
        $response = $this->client->request("POST", "$baseUrl/credit/api/v1/check", [
            GuzzleHttp\RequestOptions::FORM_PARAMS => $this->generateFormParams($date ?? Carbon::now()),
        ]);
        $body = \json_decode((string)$response->getBody(), true);

        $isKeysExists = \array_key_exists('data', $body)
            && \array_key_exists('sign', $body)
            && \array_key_exists('api_key', $body);

        if (!$isKeysExists) {
            throw new InvalidResponseException("Missing keys in response", 1, $body);
        }

        if ($body['api_key'] !== $this->config->getPublicKey()) {
            throw new InvalidResponseException("Invalid api_key given", 2, $body);
        }

        $this->validateResponseSign($body);

        $responses = [];
        foreach ($body['data'] as $account => $statistics) {
            $responses[] = new Response(
                $statistics['id'],
                $statistics['type'],
                $account,
                Carbon::parse($statistics['date']),
                $this->formatAmount($statistics['outcome']),
                $this->formatAmount($statistics['sum']),
                $statistics
            );
        }

        return $responses;
    }

    protected function formatAmount(string $amount): float
    {
        return (float)\str_replace(['&nbsp;', ','], ['', '.'], $amount);
    }

    /**
     * @param array $body
     * @throws InvalidResponseException
     */
    protected function validateResponseSign(array $body): void
    {
        if (empty($body['data'])) {
            return;
        }

        $sign = \array_reduce($body['data'], function (string $carry, array $statistics): string {
            return $carry . \implode($statistics);
        }, '');

        if (\hash('sha256', $sign . $this->config->getPrivateKey()) !== $body['sign']) {
            throw new InvalidResponseException("Damaged data obtained", 3, $body);
        }
    }

    protected function generateFormParams(\DateTimeInterface $date): array
    {
        $params = [
            'api_key' => $this->config->getPublicKey(),
            'date' => $date->format('Y-m-d H:i:s'),
        ];
        return [
            'data' => $params,
            'sign' => \hash("sha256", \implode($params) . $this->config->getPrivateKey()),
        ];
    }
}
