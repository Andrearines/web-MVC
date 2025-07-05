<?php

class Environment
{
    private static $variables = [];
    private static $loaded = false;

    /**
     * Carga las variables de entorno desde el archivo .env
     */
    public static function load($path = null)
    {
        if (self::$loaded) {
            return;
        }

        $envFile = $path ?: __DIR__ . '/../.env';
        
        if (!file_exists($envFile)) {
            throw new Exception("Archivo .env no encontrado en: " . $envFile);
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignorar comentarios
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Separar clave y valor
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remover comillas si existen
                if (preg_match('/^"(.*)"$/', $value, $matches)) {
                    $value = $matches[1];
                } elseif (preg_match("/^'(.*)'$/", $value, $matches)) {
                    $value = $matches[1];
                }

                self::$variables[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    /**
     * Obtiene una variable de entorno
     */
    public static function get($key, $default = null)
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$variables[$key] ?? $default;
    }

    /**
     * Obtiene una variable de entorno como booleano
     */
    public static function getBool($key, $default = false)
    {
        $value = self::get($key, $default);
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Obtiene una variable de entorno como entero
     */
    public static function getInt($key, $default = 0)
    {
        $value = self::get($key, $default);
        return (int) $value;
    }

    /**
     * Verifica si existe una variable de entorno
     */
    public static function has($key)
    {
        if (!self::$loaded) {
            self::load();
        }

        return isset(self::$variables[$key]);
    }

    /**
     * Obtiene todas las variables de entorno
     */
    public static function all()
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$variables;
    }
} 