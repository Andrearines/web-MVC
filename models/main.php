<?php
/**
 * Clase main
 *
 * Esta clase proporciona una implementación base para modelos en el patrón MVC.
 * Incluye métodos para operaciones CRUD, validación, manejo de errores y gestión de imágenes.
 *
 * Métodos principales:
 * - setDb($database): Establece la conexión a la base de datos.(en app.php)
 * - validate(): Valida los datos del modelo y llena el arreglo de errores si es necesario.
 * - createError($type, $msg): Agrega un mensaje de error de validación.
 * - all(): Retorna todos los registros de la tabla asociada.
 * - find($id): Busca un registro por su ID.
 * - findBy($column, $value): Busca un registro por una columna específica.
 * - create($data): Crea una instancia del modelo a partir de un arreglo de datos.
 * - update($data): Actualiza el registro actual con los datos proporcionados.
 * - delete(): Elimina el registro actual de la base de datos.
 * - findAllBy($column, $value): Busca todos los registros que coincidan con una columna.
 * - save(): Inserta el registro actual en la base de datos si no hay errores de validación.
 * - getErrors($type = null): Obtiene los errores de validación.
 * - img($imagen): Procesa y guarda una imagen, retornando el nombre generado.
 *
 * Nota: Esta clase está pensada para ser extendida por modelos concretos que definan la tabla y los atributos específicos.
 */
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

  
       
    

