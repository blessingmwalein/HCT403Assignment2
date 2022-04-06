<?php


require_once  'app/Controllers/UserController.php';
require_once  'app/Controllers/StationController.php';
require_once  'app/Controllers/CableController.php';


include_once 'Request.php';
include_once 'Router.php';

$router = new Router(new Request);
$userController = new Vendor\Test\Controllers\UserController();
$stationController = new Vendor\Test\Controllers\StationController();
$cableController  = new \Vendor\Test\Controllers\CableController();

$router->post('/register-user', function($request) use ($userController) {
   $userController->registerUser($request->getBody());
});
$router->post('/login-user', function ($request) use ($userController){
    $userController->loginUser($request->getBody());
});
$router->get('/profile', function($request) use ($userController) {
//    return json_encode($request->getAuthorisationHeader());
    $userController->getUserData($request->getAuthorisationHeader());
});

$router->post('/data', function($request) use ($userController) {
  return json_encode($request->getBody());
});

//store stations
$router->post('/stations/store', function ($request) use ($stationController) {
    $stationController->store($request->getBody());
});

$router->get('/stations', function () use ($stationController) {
    $stationController->index();
});

//store cables
$router->post('/cables/store', function ($request) use ($cableController) {
    $cableController->store($request->getBody());
});
$router->get('/cables', function () use ($cableController) {
    $cableController->index();
});
$router->get('/cable/single', function ($request) use ($cableController){
    printf($request->getBody());
});