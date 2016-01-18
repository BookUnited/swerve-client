<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Poi
 * @package BookUnited\Swerve\Client
 */
class Poi extends Entity implements Arrayable {

    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $short_description;

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
     * @var
     */
    protected $images;

    /**
     * @var
     */
    protected $distance;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getShortDescription()
    {
        return $this->short_description;
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

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'short_description' => $this->short_description,
            'description'       => $this->description,
            'address'           => $this->address,
            'zip_code'          => $this->zip_code,
            'images'            => $this->images->toArray(),
            'distance'          => $this->distance
        ];
    }

}