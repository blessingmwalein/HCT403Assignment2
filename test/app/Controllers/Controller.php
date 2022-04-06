<?php

namespace Vendor\Test\Controllers;
require_once 'vendor/firebase/php-jwt/src/JWT.php';
require_once 'vendor/firebase/php-jwt/src/Key.php';

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JsonSerializable;
use Vendor\Test\Models\User;

class Controller implements JsonSerializable
{

    public function throwError($code, $message)
    {
        $errorMsg = json_encode(['error' => ['status' => $code, 'message' => $message]]);
        echo $errorMsg;
        exit;
    }

    public function returnResponse($code, $data)
    {
        $response = json_encode(['response' => ['status' => $code, "result" => $data]]);
        echo $response;
        exit;
    }


    public function getBearerToken($auth)
    {
//        $headers = $auth();
//        print_r($auth); exit();

        if (!empty($auth)) {
            if (preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
                return $matches[1];
            }
        }
        $this->throwError(403, 'Access Token Not found');
    }


    public function generateToken($request, $user)
    {
        try {
            $paylod = [
                'iat' => time(),
                'iss' => 'localhost',
                'exp' => time() + (15 * 60),
                'userId' => $user['id']
            ];

            return JWT::encode($paylod, 'bling', 'HS256');
        } catch (Exception $e) {
            $this->throwError(403, $e->getMessage());
        }
    }

    public function validateToken($auth) {
        try {
//            print_r($auth); exit();
            $token = $this->getBearerToken($auth);
            $authData =  JWT::decode($token, new Key('bling', 'HS256'));
            print_r($authData->userId);
            $user = new User('','', '');
            $user->setId($authData->userId);
            $user = $user->findBy('id', $user->id,$user->tableName);
//            return ;\
            $this->returnResponse(200, ['token' => $token,'user' => $user]);
        } catch (Exception $e) {
            $this->throwError(403, $e->getMessage());
        }
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}