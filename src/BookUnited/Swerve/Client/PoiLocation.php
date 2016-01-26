<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PoiLocation
 * @package BookUnited\Swerve\Client
 */
class PoiLocation extends Entity implements Arrayable {

    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name
        ];
    }
}