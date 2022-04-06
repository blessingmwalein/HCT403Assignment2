<?php

namespace Vendor\Test\Models;

require_once 'app/Models/Model.php';

class Cable extends Model
{
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
    public function getCableId()
    {
        return $this->cableId;
    }

    /**
     * @param mixed $cableId
     */
    public function setCableId($cableId): void
    {
        $this->cableId = $cableId;
    }

    /**
     * @return mixed
     */
    public function getPointLocation()
    {
        return $this->lineString;
    }

    /**
     * @param mixed $pointLocation
     */
    public function setPointLocation($pointLocation): void
    {
        $this->lineString = $pointLocation;
    }
    public $stationId;
    public $id;
    public $name;
    public $cableId;
    public $lineString;
    public $tableName = 'cables';
    public $columns = ['name', 'stationId', 'id', 'lineString', 'cableId'];
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @param $stationId
     * @param $name
     * @param $cableId
     * @param $pointLocation
     */
    public function __construct($stationId, $name, $cableId, $lineString)
    {
        $this->stationId = $stationId;
        $this->name = $name;
        $this->cableId = $cableId;
        $this->lineString = $lineString;
        $this->columns = ['name', 'stationId', 'id', 'lineString', 'cableId'];
    }

    public function sql()
    {
        return 'SELECT cables.name, cables.stationId, cables.id, cables.cableId, ST_AsText(cables.lineString) as lineString ,stations.name as stationName from ' . $this->tableName . ' INNER JOIN stations
        ON cables.stationId = stations.id';
    }
}
