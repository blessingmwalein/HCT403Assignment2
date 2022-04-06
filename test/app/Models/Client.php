<?php

namespace Vendor\Test\Models;
require_once 'app/Models/Model.php';

class Client extends Model
{
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
    public function setId($id): void
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPointLocation()
    {
        return $this->pointLocation;
    }

    /**
     * @param mixed $pointLocation
     */
    public function setPointLocation($pointLocation): void
    {
        $this->pointLocation = $pointLocation;
    }

    /**
     * @return mixed
     */
    public function getStationId()
    {
        return $this->stationId;
    }

    /**
     * @param mixed $stationId
     */
    public function setStationId($stationId): void
    {
        $this->stationId = $stationId;
    }
    public $id;
    public $name;
    public $address;
    public $pointLocation;
    public $stationId;

    /**
     * @param $name
     * @param $address
     * @param $pointLocation
     * @param $stationId
     */
    public function __construct($name, $address, $pointLocation, $stationId)
    {
        $this->name = $name;
        $this->address = $address;
        $this->pointLocation = $pointLocation;
        $this->stationId = $stationId;
    }


}