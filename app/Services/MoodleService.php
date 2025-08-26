<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class MoodleService
{
    private $client;
    private $url;
    private $token;

    public function __construct()
    {
        $this->url = 'http://localhost/moodle/webservice/rest/server.php';
        $this->token = '7244ddd0a3439c9334e6eb3e4db26cff';
        $this->client = new Client();
    }

    public function callMoodle($function, $params = [])
    {
        $defaultParams = [
            'wstoken' => $this->token,
            'wsfunction' => $function,
            'moodlewsrestformat' => 'json'
        ];

        try {
            $response = $this->client->get($this->url, [
                'query' => array_merge($defaultParams, $params)
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['exception'])) {
                throw new Exception($data['message']);
            }

            return $data;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
