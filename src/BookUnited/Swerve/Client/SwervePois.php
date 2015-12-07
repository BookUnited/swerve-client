<?php

namespace BookUnited\Swerve\Client;

use GuzzleHttp\Client;

/**
 * Class SwervePois
 * @package BookUnited\Swerve\Client
 */
class SwervePois extends SwerveClient
{
    /**
     * @param $lat
     * @param $lng
     * @param array $options
     */
    public function find($lat, $lng, array $options = [])
    {
        $query = ['near' => sprintf("%s,%s", $lat, $lng)];

        if (array_has($options, 'with') && is_array($options['with'])) {
            $query['with'] = implode(',', $options['with']);
        }

        if (array_has($options, 'max') && ctype_digit($options['max'])) {
            $query['max'] = $options['max'];
        }

        $response = $this->get(sprintf('%s/api/v1/poi', config('swerve.api_url')), $query);

        return $response;
    }

}