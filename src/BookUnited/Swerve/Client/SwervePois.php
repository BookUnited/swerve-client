<?php

namespace BookUnited\Swerve\Client;

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

        if (array_has($options, 'include') && is_array($options['include'])) {
            $query['include'] = implode(',', $options['include']);
        }

        if (array_has($options, 'max') && ctype_digit($options['max'])) {
            $query['max'] = $options['max'];
        }

        if (array_has($options, 'contains')) {
            $query['contains'] = $options['contains'];
        }

        $results = $this->get(sprintf('%s/api/v1/poi', config('swerve.api_url')), $query);

        $pois = new Collection();

        foreach(array_get($results, 'data', []) as $attributes) {
            $pois->push($this->toEntity($attributes, array_get($results, 'included', [])));
        }

        return $pois->reverse();
    }

    /**
     * @param array $attributes
     * @param array $included
     * @return Poi
     */
    private function toEntity(array $attributes, array $included)
    {
        $poi = [
            'id'            => array_get($attributes, 'id'),
            'name'          => array_get($attributes, 'attributes.name'),
            'description'   => array_get($attributes, 'attributes.description'),
            'address'       => array_get($attributes, 'attributes.address'),
            'zip_code'      => array_get($attributes, 'attributes.zip_code'),
            'distance'      => array_get($attributes, 'attributes.distance'),
            'images'        => new Collection()
        ];

        foreach(array_get($attributes, 'relationships.images.data', []) as $image) {
            $image = $this->getInclude($included, 'images', $image['id']);

            if (!$image) continue;

            $poi['images']->push(new PoiImage([
                'url'       => $image['attributes']['url'],
                'name'      => $image['attributes']['image_name'],
                'width'     => $image['attributes']['width'],
                'height'    => $image['attributes']['height']
            ]));
        }

        return new Poi($poi);
    }

    /**
     * @param array $included
     * @param $type
     * @param $id
     * @return bool
     */
    private function getInclude(array $included, $type, $id)
    {
        foreach($included as $include) {
            if ($include['type'] == $type && $include['id'] == $id) {
                return $include;
            }
        }

        return false;
    }

}