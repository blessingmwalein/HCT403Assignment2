<?php

namespace Vendor\Test\Controllers;
require_once 'app/Models/User.php';
require_once 'app/Controllers/Controller.php';

use Vendor\Test\Models\User;

class UserController extends Controller
{

    public function registerUser($request){
       $user = new User($request['name'], $request['email'], $request['password']);
       if($user->save($request, $user->tableName)){
           $this->returnResponse(201, 'User created');
       }
    }

    public function loginUser($request){
        $user= new User('', $request['email'], $request['password']);
        $user = $user->findBy('email', $request['email'], $user->tableName);

        if(!is_array($user)) {
            $this->returnResponse(403, "Email or Password is incorrect.");
        }

        $token = $this->generateToken($request, $user);

        $data = ['token' => $token,'user' => $user];
        $this->returnResponse(200, $data);
    }

    public function getUserData($auth){
        $this->validateToken($auth);
    }
}