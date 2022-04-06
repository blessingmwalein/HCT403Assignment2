<?php

namespace Vendor\Test\Models;
require_once 'app/Models/Model.php';
class StationNetworkSpeed extends Model
{
  public $stationId;
  public $speed;
  public $dateOn;
}