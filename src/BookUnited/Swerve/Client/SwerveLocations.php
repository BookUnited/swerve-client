<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Support\Collection;

/**
 * Class SwerveLocations
 * @package BookUnited\Swerve\Client
 */
class SwerveLocations extends SwerveClient
{
    /**
     * @param $query
     * @return Collection
     */
    public function find($query)
    {
        $results = $this->get(sprintf('%s/api/v1/location', config('swerve.api_url')), [
            'contains' => $query
        ]);

        $locations = new Collection();

        foreach (array_get($results, 'data', []) as $attributes) {
            $locations->push(new PoiLocation([
                'id'    => array_get($attributes, 'attributes.id'),
                'name'  => array_get($attributes, 'attributes.name')
            ]));
        }

        return $locations;
    }

    /**
     * @param PoiLocation $location
     * @return Collection
     */
    public function pois(PoiLocation $location)
    {
        $results = $this->get(sprintf('%s/api/v1/location/%s', config('swerve.api_url'), $location->getName()), [
            'include' => 'pois'
        ]);

        $pois = new Collection();

        foreach (array_get($results, 'included', []) as $attributes) {
            if (array_get($attributes, 'type') == 'poi') {
                $pois->push($attributes);
            }
        }

        return $pois;
    }

    /**
     * @param array $attributes
     * @param array $included
     * @return array
     */
    private function toEntity(array $attributes, array $included)
    {
        return [
            'id'                => array_get($attributes, 'id'),
            'name'              => array_get($attributes, 'attributes.name'),
            'short_description' => array_get($attributes, 'attributes.short_description'),
            'description'       => array_get($attributes, 'attributes.description'),
            'address'           => array_get($attributes, 'attributes.address'),
            'zip_code'          => array_get($attributes, 'attributes.zip_code'),
            'distance'          => array_get($attributes, 'attributes.distance')
        ];
    }

}