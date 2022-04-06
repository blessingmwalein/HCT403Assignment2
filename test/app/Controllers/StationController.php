<?php

namespace Vendor\Test\Controllers;
require_once 'app/Controllers/Controller.php';
require_once 'app/Models/Station.php';

use Vendor\Test\Models\Station;


class StationController extends Controller
{

    public function index(){
        $station = new Station('','','');
        $data =$station->getAllData($station->sql());
        $this->returnResponse(200, $data);
    }
    public function store($request){
        $station = new Station($request['name'], $request['pointLocation'], $request['address']);
        if($station->save($request, $station->tableName)){
            $this->returnResponse(201, 'Station created');
        }
    }
}