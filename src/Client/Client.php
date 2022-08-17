<?php

namespace PhpTek\Mataara\Client;

/**
 * Simple Guzzle client which sends report payloads to Mataara.
 */

class Client extends GuzzleHttpClient
{
    /**
     * @var array
     */
    private static $config = [];
}