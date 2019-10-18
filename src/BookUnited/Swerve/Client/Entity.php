<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Support\Arr;

/**
 * Class Entity
 * @package BookUnited\Swerve\Client
 */
abstract class Entity {

    /**
     * Poi constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach(array_keys(get_class_vars(static::class)) as $name) {
            $this->$name = Arr::get($attributes, $name);
        }
    }

}