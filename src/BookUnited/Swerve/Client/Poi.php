<?php

namespace BookUnited\Swerve\Client;

/**
 * Class Poi
 * @package BookUnited\Swerve\Client
 */
class Poi extends Entity {

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
     * @var
     */
    protected $images;

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

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

}