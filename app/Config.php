<?php


namespace App;

class Config
{
    private $data;
    private static Config $instance;

    private function __construct()
    {
        $json = file_get_contents('/mnt/c/projects/person-registry/public/utils/app.json');
        $this->data = json_decode($json, true);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function get(string $key)
    {
        if (!isset($this->data[$key])) {
            throw new \InvalidArgumentException("Key $key not in config.");
        }
        return $this->data[$key];
    }

}