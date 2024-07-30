<?php

namespace App\Helpers;

use App\Models\Client;
use GuzzleHttp\Exception\RequestException;

class TTEHelper
{
    private $url = null;
    private $username = null;
    private $password = null;
    private $payload = [
        [
            'name' => 'tampilan',
            'contents' => 'visible'
        ],
        [
            'name' => 'image',
            'contents' => 'true'
        ],
        [
            'name' => 'width',
            'contents' => '80'
        ],
        [
            'name' => 'height',
            'contents' => '80'
        ],
        [
            'name' => 'tag_koordinat',
            'contents' => '$'
        ],
    ];

    public function __construct()
    {
        $this->url = env("TTE_URL");
        $this->username = env("TTE_USERNAME");
        $this->password = env("TTE_PASSWORD");
    }

    function post($file, $ttd, $nik, $passphrase)
    {
        try {
            $res = $this->request('POST', $this->url . '/api/sign/pdf', array_merge($this->payload, [
                [
                    'name' => 'file',
                    'contents' => $file
                ],
                [
                    'name' => 'imageTTD',
                    'contents' => $ttd
                ],
                [
                    'name' => 'nik',
                    'contents' => $nik
                ],
                [
                    'name' => 'passphrase',
                    'contents' => $passphrase
                ]
            ]));
        } catch (RequestException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        $robj = $res->getBody()->getContents();
        return $robj;
    }

    private function request($method = 'GET', $url = null, $data = [], $headers = [])
    {
        $client = new \GuzzleHttp\Client();
        // dd([
        //     'multipart' => $data,
        //     'headers' => array_merge([
        //         'Authorization' => "Basic " . base64_encode("$this->username:$this->password"),
        //         'Content-Type' => 'multipart/form-data',
        //         'User-Agent' => 'SI-LAJANG/' . date('Y'),
        //     ], $headers)
        // ]);

        $response = $client->request($method, $url, [
            'multipart' => $data,
            'headers' => array_merge([
                'Authorization' => "Basic " . base64_encode("$this->username:$this->password"),
                // 'Content-Type' => 'multipart/form-data',
                'User-Agent' => 'SI-LAJANG/' . date('Y'),
            ], $headers)
        ]);

        return $response;
    }
}
