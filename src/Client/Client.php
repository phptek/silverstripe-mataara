<?php

namespace PhpTek\Mataara\Client;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\RequestOptions as GuzzleRequestOpts;

/**
 * Simple Guzzle client which sends report payloads to Mataara.
 * 
 * @author Russell Michell <russ@theruss.com>
 * @package phptek/silverstripe-mataara
 */

class Client
{
    use Injectable;
    use Configurable;

    /**
     * @var array
     */
    private const VALID_TRANSPORTS = [
        'http',
        'email',
    ];

    /**
     *  As per Mataara's instructions.
     * 
     * @var string
     */
    private const ENCRYPTION_CIPHER = 'RC4';

    /**
     * Return the client's public key.
     * 
     * @return string
     * @throws Exception
     */
    public function getPubKey(): string
    {
        if (!$opt = $this->config()->get('opts')['public_key']) {
            throw new \Exception('Missing Mataara public-key');
        }

        return $opt;
    }

    /**
     * Return the Mataara instance's hostname or email.
     * 
     * @return string
     * @throws Exception
     */
    public function getAddress(): string
    {
        if (!$opt = $this->config()->get('opts')['address']) {
            throw new \Exception('Missing Mataara hostname or email!');
        }

        return $opt;
    }

    /**
     * Return the desired data-sending interval.
     * 
     * @return string
     * @throws Exception
     */
    public function getInterval(): int
    {
        if (!$opt = $this->config()->get('opts')['interval']) {
            throw new \Exception('Missing data-frequency interval!');
        }

        if (!is_numeric($this->config()->get('opts')['interval'])) {
            throw new \Exception('Data-frequency interval should be numeric!');
        }

        return (int) $opt;
    }

    /**
     * Encrypt the payload with the configured Mataara public key.
     * 
     * @see https://mataara.readthedocs.io/en/latest/development/report_format.html#encryption
     * @param string Un-encrypted JSON payload
     * @return string Encrypted payload
     * @throws Exception
     */
    public function encrypt(string $payload): string
    {
        if (!$pubKey = openssl_pkey_get_public($this->getPubKey())) {
            $msg = sprintf('Error reading public key: ', openssl_error_string());
            throw new \Exception($msg);   
        }

        $sealed = '';
        $keys = [];
        $cipher = self::ENCRYPTION_CIPHER;

        // Seal the data, generating ekeys (one per key)
        openssl_seal($payload, $sealed, $keys, [$pubKey], $cipher);
        
        // Fee the key from internal memory (openssl_free_xx() functions are deprecated in PHP8)
        //openssl_free_key($pubkey);

        return base64_encode($sealed);
    }

    /**
     * Send the report payload using the HTTP transport mode.
     * 
     * @param string $data An array designed for Mataara comprising the encrypted report.
     * @return string The response received back from Mataara
     */
    public function sendAsHttp(array $data): string
    {
        $client = new GuzzleClient();
        $options = [
            GuzzleRequestOpts::FORM_PARAMS => $data,
        ];
        $request = new GuzzleRequest('POST', sprintf('https://%s', $this->getHost()));
        $responseBody = '';
        $promise = $client->sendAsync($request, $options)->then(function ($response) use (&$responseBody) {
            $responseBody = $response->getBody();
        });
        $promise->wait();

        return $responseBody;
    }

    /**
     * Send the report payload using the EMAIL transport mode.
     * 
     * @param string $data An array designed for Mataara comprising the encrypted report.
     * @return string The response received back from Mataara
     * @throws Exception
     * @todo Implement
     */
    public function sendAsEmail(array $data): string
    {
        throw new \Exception('Non-HTTP transport modes not yet supported!');
    }

    /**
     * Send a payload somewhere asynchronously by default.
     * 
     * @param string $payload The un-encrypted report payload to send to Mataara.
     * @return string
     * @throws Exception
     */
    public function send(string $payload): string
    {
        $data = [
            'ek' => $this->getPubKey(),
            'enc' => $this->encrypt($payload),
        ];
        $mode = $this->config()->get('mode');

        if (!in_array($mode, self::VALID_TRANSPORTS)) {
            $msg = sprintf(
                'Incompatible transport mode! Only %s are permitted',
                implode(', ', self::VALID_TRANSPORTS)
            );
            throw new \Exception($msg);
        }

        if ($mode === 'http') {
            return $this->sendAsHttp($data);
        }

        return $this->sendAsEmail($data);
    }
}