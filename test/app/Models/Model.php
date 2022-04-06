<?php

namespace Vendor\Test\Models;

require_once 'app/Config/Database.php';

use JsonSerializable;
use PDO;
use Vendor\Test\Config\Database;

abstract class Model extends Database
{

    public function __construct()
    {
        $this->connect();
    }


    public function save(array $data, $tableName)
    {
        $conn = $this->connect();
        $sql = 'INSERT INTO ' . $tableName . ' (' . $this->getFields($data) . ') VALUES (' . $this->getFieldsValues($data) . ')';
        $stmt = $conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam(':' . $key, $value);
        }
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getFields(array $fields)
    {
        $keyString = '`';
        foreach ($fields as $key => $field) {
            if (array_key_last($fields) == $key) {
                $keyString .= $key;
            } else {
                $keyString .= $key . '` , `';
            }
        }
        return $keyString . '`';
    }

    public function getFieldsValues(array $fields)
    {
        $valueString = '\'';
        foreach ($fields as $key => $value) {
            $valueString = $this->getStrField($value, $valueString);
        }
        return substr($valueString, 0, -3);
    }

    public function getFieldsPoint($class)
    {
        $class_vars =  $class->columns;
        $valueString = '`';
        foreach ($class_vars as $name) {
            $valueString = $this->getStrFieldPoint($name, $valueString);
        }

        return substr($valueString, 0, -3);
    }

    public function getAll($tableName, $class)
    {
        $conn = $this->connect();

        $sql = 'SELECT ' . $this->getFieldsPoint($class) . ' FROM ' . $tableName;

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllData($sql)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findById($tableName, $id)
    {
        $conn = $this->connect();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id=' . $id;
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy($field, $value, $tableName)
    {
        $conn = $this->connect();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $field . '=\'' . $value . '\'';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':' . $field, $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $value
     * @param string $valueString
     * @return string
     */
    private function getStrField($value, string $valueString): string
    {

        if (strpos($value, 'POINT') !== false) {
            $valueString  =  substr($valueString, 0, -1) . $value . ', \'';
        } else if (strpos($value, 'LINESTRING') !== false) {
            $valueString = substr($valueString, 0, -1);
            $valueString .= 'GeomFromText(\'' . $value . '\') , \'';
        } else {
            $valueString .= $value . '\' , \'';
        }

        return $valueString;
    }

    private function getStrFieldPoint($value, string $valueString): string
    {
        if ($value == 'pointLocation') {
            $valueString  = 'ST_AsText(' . $value . ')' . ', `';
        } else {
            $valueString .= $value . '` , `';
        }
        return $valueString;
    }
}
