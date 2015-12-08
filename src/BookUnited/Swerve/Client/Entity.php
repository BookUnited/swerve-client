<?php

namespace BookUnited\Swerve\Client;

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
        foreach(array_keys(get_class_vars($this::class)) as $name) {
            $this->$name = array_get($attributes, $name);
        }
    }

}