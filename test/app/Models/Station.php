<?php

namespace Vendor\Test\Models;

require_once 'app/Models/Model.php';

class Station extends Model
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
    public $id;
    public $name;
    public $pointLocation;
    public $address;

    public string $tableName ='stations';

    public $columns;
    /**
     * @return string
     */

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @param $name
     * @param $pointLocation
     * @param $address
     */
    public function __construct($name, $pointLocation, $address)
    {
        $this->name = $name;
        $this->pointLocation = $pointLocation;
        $this->address = $address;
        $this->columns = ['name', 'id', 'address','pointLocation'];
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns): void
    {
        $this->columns = $columns;
    }


    public function sql(){
        return 'SELECT id ,name, address, ST_AsText(pointLocation) as pointLocation from '.$this->tableName;
    }
}