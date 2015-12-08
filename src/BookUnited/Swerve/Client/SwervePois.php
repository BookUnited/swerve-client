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

        $pois = new Collection();

        foreach($results['data'] as $attributes) {
            $pois->push($this->toEntity($attributes, []));
        }

        return $pois->reverse();
    }

    /**
     * @param array $attributes
     * @return Poi
     */
    private function toEntity(array $attributes, array $includes)
    {
        return new Poi([
            'id'            => $attributes['id'],
            'name'          => $attributes['attributes']['name'],
            'description'   => $attributes['attributes']['description'],
            'address'       => $attributes['attributes']['address'],
            'zip_code'      => $attributes['attributes']['zip_code']
        ]);
    }

}