<?php

require_once 'ApplicationConfig.php';

class Application {
    
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Application();
        }
        return self::$instance;
    }
    
    
    public function getCurrentDateTime() {
        $config = ApplicationConfig::getInstance();
        $timeZone = $config->getTimeZone();
        date_default_timezone_set($timeZone); 
        return new DateTime('now');
    }

    // Возвращает дату c временем установленным на момент начала суток(00:00:00)
    public function getCurrentDate() {
        $config = ApplicationConfig::getInstance();
        $timeZone = $config->getTimeZone();
        date_default_timezone_set($timeZone); 
        $date = new DateTime('now');
        $date->setTime(0, 0, 0);
        return $date;
    }
    
    
    private function __construct() {

    }
    
}
