#!/usr/bin/env php
<?php

use Wearesho\Bobra\Platon;

include dirname(__DIR__) . '/vendor/autoload.php';

$publicKey = readline("Public Key: ");
$privateKey = readline("Private Key: ");

$config = new Platon\Config($publicKey, $privateKey, 'CC');
$client = new GuzzleHttp\Client();

$repository = new Platon\Info\Repository($config, $client);

$responses = $repository->get();
echo json_encode($responses, JSON_PRETTY_PRINT)
    . PHP_EOL . PHP_EOL
    . implode(PHP_EOL, $responses)
    . PHP_EOL;
