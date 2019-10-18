<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

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
        $results = $this->get(sprintf('%s/api/v1/location', Config::get('swerve.api_url')), [
            'contains' => $query,
        ]);

        $locations = new Collection();

        foreach (Arr::get($results, 'data', []) as $attributes) {
            $locations->push(new PoiLocation([
                'id'   => Arr::get($attributes, 'attributes.id'),
                'name' => Arr::get($attributes, 'attributes.name'),
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
        $results = $this->get(sprintf('%s/api/v1/location/%s', Config::get('swerve.api_url'), $location->getName()), [
            'include' => 'pois',
        ]);

        $pois = new Collection();

        foreach (Arr::get($results, 'included', []) as $attributes) {
            if (Arr::get($attributes, 'type') == 'poi') {
                $pois->push($this->toEntity($attributes));
            }
        }

        return $pois;
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function toEntity(array $attributes)
    {
        return [
            'id'                => Arr::get($attributes, 'id'),
            'name'              => Arr::get($attributes, 'attributes.name'),
            'short_description' => Arr::get($attributes, 'attributes.short_description'),
            'description'       => Arr::get($attributes, 'attributes.description'),
            'address'           => Arr::get($attributes, 'attributes.address'),
            'zip_code'          => Arr::get($attributes, 'attributes.zip_code'),
            'distance'          => Arr::get($attributes, 'attributes.distance'),
        ];
    }
}