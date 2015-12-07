<?php

namespace BookUnited\Swerve\Client;

use GuzzleHttp\Client;

/**
 * Class SwerveClient
 * @package BookUnited\Swerve\Client
 */
class SwervePois {

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

    public function get($lat, $lng, array $options = [])
    {
        $query = ['near' => sprintf("%s,%s", $lat, $lng)];

        if (array_has($options, 'with') && is_array($options['with'])) {
            $query['with'] = implode(',', $options['with']);
        }

        if (array_has($options, 'max') && ctype_digit($options['max'])) {
            $query['max'] = $options['max'];
        }

        $this->client->get(sprintf('%s/api/v1/poi', config('swerve.api_url')), [
            'headers' => [
                'Api-Key' => config('swerve.api_key')
            ],
            'query' => $query
        ]);
    }

}