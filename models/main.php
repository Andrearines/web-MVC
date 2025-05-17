<?php

namespace models;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
class main
{
    public static $table;
    public static $db;
    
    public static $errors = [];

    public function __construct($data = [])
    {
       
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

    if ($row = $result->fetch_assoc()) {
        return static::create($row);
    }
    return null;
}

public static function findBy($column, $value){
    $value = self::$db->real_escape_string($value);
    $query = "SELECT * FROM " . static::$table . " WHERE $column = '$value' LIMIT 1";
    $result = self::$db->query($query);

    if ($row = $result->fetch_assoc()) {
        return static::create($row);
    }
    return null;
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

      private function img($imagen){   
        $nombre_img=md5(uniqid(rand(),true )).".png";
        //echo $nombre_img; exit;
       $manager=new ImageManager(Driver::class);
       $imagen=$manager->read($imagen['tmp_name'])->cover(900,900);
       $imagen->save(__DIR__ . '/../public/imagenes/'.$nombre_img);
       return  $nombre_img;
    }

    public function getErrors($type = null){
        if($type){
            return static::$errors[$type] ?? null;
        }
        return static::$errors;}
}

  
       
    

