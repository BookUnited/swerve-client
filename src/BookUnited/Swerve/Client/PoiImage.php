<?php

namespace BookUnited\Swerve\Client;

/**
 * Class PoiImage
 * @package BookUnited\Swerve\Client
 */
class PoiImage extends Entity
{

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}