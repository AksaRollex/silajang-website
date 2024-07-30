<?php

namespace App\Services;

class WhatsApp
{
    private $client;
    private $key;
    private $url;
    private $phone;

    public function __construct($phone = null)
    {
        $this->client = new \GuzzleHttp\Client();
        $this->key = getEnv('WA_KEY');
        $this->url = getEnv('WA_URL');
        $this->phone = $phone;
    }

    public function send($message)
    {
        try {
            $response = $this->client->request('POST', $this->url . 'v5/send', [
                'json' => [
                    'ApiKey' => $this->key,
                    'Phone' => $this->phone,
                    'Message' => $message,
                ],
                'headers' => [
                    'User-Agent' => 'SI-LAJANG/' . date('Y'),
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    public function sendFile($fileUrl)
    {
        try {
            $response = $this->client->request('POST', $this->url . 'v5/sendFile', [
                'json' => [
                    'ApiKey' => $this->key,
                    'Phone' => $this->phone,
                    'FileUrl'   => $fileUrl,
                    'FileType'  => pathinfo($fileUrl, PATHINFO_EXTENSION),
                    'Filename'  => basename($fileUrl),
                ],
                'headers' => [
                    'User-Agent' => 'SI-LAJANG/' . date('Y'),
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    public function getStatus()
    {
        try {
            $response = $this->client->request('POST', $this->url . 'v5/auth', [
                'json' => [
                    'ApiKey' => $this->key,
                ],
                'headers' => [
                    'User-Agent' => 'SI-LAJANG/' . date('Y'),
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
        }

        $response = json_decode($response->getBody(), true);

        if (in_array($response['auth'], ['connected', 'scan', 'loading'])) {
            return $response;
        } else {
            return false;
        }
    }
}
