<?php

namespace Vendor\Test\Controllers;

require_once 'app/Controllers/Controller.php';
require_once 'app/Models/Station.php';
require_once 'app/Models/Cable.php';


use Vendor\Test\Models\Cable;
use Vendor\Test\Models\Station;

class CableController extends Controller
{
    public function index()
    {
        $cable = new Cable('', '', '', '');
        $data = $cable->getAllData($cable->sql());
        $this->returnResponse(200, $data);
    }
    public function store($request)
    {

        $cable = new Cable($request['stationId'], $request['name'], $request['cableId'], $request['lineString']);
        if ($cable->save($request, $cable->tableName)) {
            $this->returnResponse(201, 'Cable created');
        }
    }
}
