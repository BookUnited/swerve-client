<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class SwervePois
 * @package BookUnited\Swerve\Client
 */
class SwervePois extends SwerveClient
{
    /**
     * @param       $lat
     * @param       $lng
     * @param array $options
     * @return string
     */
    public function find($lat, $lng, array $options = [])
    {
        $query = ['near' => sprintf("%s,%s", $lng, $lat)];

        if (Arr::has($options, 'with') && is_array($options['with']) && !empty($options['with'])) {
            $query['with'] = implode(',', $options['with']);
        }

        if (Arr::has($options, 'without') && is_array($options['without']) && !empty($options['without'])) {
            $query['without'] = implode(',', $options['without']);
        }

        if (Arr::has($options, 'include') && is_array($options['include']) && !empty($options['include'])) {
            $query['include'] = implode(',', $options['include']);
        }

        if (Arr::has($options, 'max') && ctype_digit((string)$options['max'])) {
            $query['max'] = $options['max'];
        }

        if (Arr::has($options, 'contains')) {
            $query['contains'] = $options['contains'];
        }

        $results = $this->get(sprintf('%s/api/v1/poi', Config::get('swerve.api_url')), $query);

        $pois = new Collection();

        foreach (Arr::get($results, 'data', []) as $attributes) {
            $pois->push($this->toEntity($attributes, Arr::get($results, 'included', [])));
        }

        return $pois;
    }

    /**
     * @param array $attributes
     * @param array $included
     * @return Poi
     */
    private function toEntity(array $attributes, array $included)
    {
        $poi = [
            'id'                => Arr::get($attributes, 'id'),
            'name'              => Arr::get($attributes, 'attributes.name'),
            'short_description' => Arr::get($attributes, 'attributes.short_description'),
            'description'       => Arr::get($attributes, 'attributes.description'),
            'address'           => Arr::get($attributes, 'attributes.address'),
            'zip_code'          => Arr::get($attributes, 'attributes.zip_code'),
            'distance'          => Arr::get($attributes, 'attributes.distance'),
            'images'            => new Collection(),
            'poi_types'         => $this->getPoiType($attributes, $included),
        ];

        foreach (Arr::get($attributes, 'relationships.images.data', []) as $image) {
            $image = $this->getInclude($included, 'images', $image['id']);

            if (!$image) {
                continue;
            }

            $poi['images']->push(new PoiImage([
                'url'     => $image['attributes']['url'],
                'name'    => $image['attributes']['image_name'],
                'width'   => $image['attributes']['width'],
                'height'  => $image['attributes']['height'],
                'focus_y' => $image['attributes']['focus_y'],
                'focus_x' => $image['attributes']['focus_x'],
            ]));
        }

        return new Poi($poi);
    }

    /**
     * @param array $included
     * @param       $type
     * @param       $id
     * @return bool
     */
    private function getInclude(array $included, $type, $id)
    {
        foreach ($included as $include) {
            if ($include['type'] == $type && $include['id'] == $id) {
                return $include;
            }
        }

        return false;
    }

    /**
     * @param $attributes
     * @param $included
     * @return mixed
     */
    private function getPoiType($attributes, $included)
    {
        $poiTypes = Arr::get($attributes, 'relationships.poiTypes.data');

        $types = [];
        foreach ($included as $include) {
            if (Arr::get($include, 'type') != "types") {
                continue;
            }

            foreach ($poiTypes as $poiType) {
                if (Arr::get($poiType, 'id') != Arr::get($include, 'id')) {
                    continue;
                }

                array_push($types, Arr::get($include, 'attributes.poiType'));
            }
        }

        return $types;
    }
}
