<?php

namespace BookUnited\Swerve\Client;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

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
     * @return string
     */
    public function find($lat, $lng, array $options = [])
    {
        $query = ['near' => sprintf("%s,%s", $lng, $lat)];

        if (array_has($options, 'with') && is_array($options['with'])) {
            $query['with'] = implode(',', $options['with']);
        }

        if (array_has($options, 'max') && ctype_digit($options['max'])) {
            $query['max'] = $options['max'];
        }

        $results = $this->get(sprintf('%s/api/v1/poi', config('swerve.api_url')), $query);

        // $pois['data'];
        $pois = array_map(function($poi) {
            return new Poi([
                'id'            => $poi['id']
                'name'          => $poi['attributes']['name'],
                'description'   => $poi['attributes']['description'],
                'address'       => $poi['attributes']['address'],
                'zip_code'      => $poi['attributes']['zip_code']
            ]);
        }, $results['data']);

        return new Collection($pois);
    }

}