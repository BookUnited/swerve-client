<?php

namespace BookUnited\Swerve\Client;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PoiImage
 * @package BookUnited\Swerve\Client
 */
class PoiImage extends Entity implements Arrayable
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
     * @var
     */
    protected $width;

    /**
     * @var
     */
    protected $height;

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

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'      => $this->name,
            'url'       => $this->url,
            'width'     => $this->width,
            'height'    => $this->height
        ];
    }

}