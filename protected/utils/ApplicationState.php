<?php

require_once 'PropertyInApplicationStateNotDefindedException.php';

class ApplicationState {

    private static $instance = null;
   
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ApplicationState();
        }
        return self::$instance;
    }
    
    public function setProperty($name, $value) {
        $state = Yii::app()->statePersister->load();
        if ($state === null) {
            $state = array();
        }
        $state[$name] = $value;
        Yii::app()->statePersister->save($state);
    }
    
    public function getProperty($name) {
        $state = Yii::app()->statePersister->load();
        if (($state === null) || !isset($state[$name]) ) {
            throw new PropertyInApplicationStateNotDefindedException();
        } else {
            return $state[$name];
        }
    }
    
    private function __construct() {
        
    }
    
}