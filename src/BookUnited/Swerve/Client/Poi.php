<?php

namespace BookUnited\Swerve\Client;

/**
 * Class Poi
 * @package BookUnited\Swerve\Client
 */
class Poi {

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $description;

    /**
     * @var
     */
    protected $address;

    /**
     * @var
     */
    protected $zip_code;

    /**
     * Poi constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach(array_keys(get_class_vars($this)) as $name) {
            $this->$name = array_get($attributes, $name);
        }
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

}