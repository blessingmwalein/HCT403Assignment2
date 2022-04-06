<?php

namespace Vendor\Test\Models;

require_once 'app/Models/Model.php';

class DataUsage extends Model
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
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param mixed $usage
     */
    public function setUsage($usage): void
    {
        $this->usage = $usage;
    }

    /**
     * @return mixed
     */
    public function getDateOn()
    {
        return $this->dateOn;
    }

    /**
     * @param mixed $dateOn
     */
    public function setDateOn($dateOn): void
    {
        $this->dateOn = $dateOn;
    }
  public $id;
  public $clientId;
  public $usage;
  public $dateOn;

    /**
     * @param $clientId
     * @param $usage
     * @param $dateOn
     */
    public function __construct($clientId, $usage, $dateOn)
    {
        $this->clientId = $clientId;
        $this->usage = $usage;
        $this->dateOn = $dateOn;
    }
}