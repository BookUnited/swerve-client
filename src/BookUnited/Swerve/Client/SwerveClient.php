<?php

namespace BookUnited\Swerve\Client;

use GuzzleHttp\Client;

/**
 * Class SwerveClient
 * @package BookUnited\Swerve\Client
 */
abstract class SwerveClient
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * SwervePois constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $url
     * @param array $query
     * @return mixed
     */
    protected function get($url, array $query = [])
    {
         $response = $this->client->get($url, [
            'headers' => [
                'Api-Key' => config('swerve.api_key')
            ],
            'query'   => $query
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}