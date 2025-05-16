<?php

namespace models;
class main
{
    public static $table;
    public static $db;
    
    public static $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
    }
    public static function setDb($database)
    {
        self::$db = $database;
    }

    public function validate()
    {
       static::$errors = [];

        return static::$errors;
       
    }

    public function createError($type, $msg){
        static::$errors[$type][] = $msg;
    }

    public static function all(){
        $query = "SELECT * FROM " . static::$table;
        $result = self::$db->query($query);
        $array = [];

        while ($row = $result->fetch_assoc()) {
            $array[] = static::create($row);
        }
        return $array;
    }

    public static function find($id){
        $id = self::$db->real_escape_string($id); 
        $query = "SELECT * FROM " . static::$table . " WHERE id = $id LIMIT 1";
        $result = self::$db->query($query);
        return $result->fetch_assoc();
    }
    public static function create($data){
        $object = new static;
        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    public function update($data){
        $query = "UPDATE " . static::$table . " SET ";
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $query .= "$key = '$value', ";
            }
        }
        $query = rtrim($query, ", ") . " WHERE id = {$this->id}";
        $result = self::$db->query($query);
        return $result;
    }

    public function delete(){
        $query = "DELETE FROM " . static::$table . " WHERE id = {$this->id}";
        $result = self::$db->query($query);
        return $result;
    }

    public static function findBy($column, $value){
        $query = "SELECT * FROM " . static::$table . " WHERE $column = '$value' LIMIT 1";
        $result = self::$db->query($query);
        return $result->fetch_assoc();
    }

    public static function findAllBy($column, $value){
        $query = "SELECT * FROM " . static::$table . " WHERE $column = '$value'";
        $result = self::$db->query($query);
        $array = [];

        while ($row = $result->fetch_assoc()) {
            $array[] = static::create($row);
        }
        return $array;
    }

    public function save(){
        $this->validate();
        if(empty(static::$errors)){
            $query = "INSERT INTO " . static::$table . " () VALUES ('{}')";
            $result = self::$db->query($query);
            return $result;
        }else{
            return false;
        }
    }

    public function getErrors($type = null){
        if($type){
            return static::$errors[$type] ?? null;
        }
        return static::$errors;}
    }

  
       
    

