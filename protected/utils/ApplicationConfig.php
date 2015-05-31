<?php

require_once 'ApplicationState.php';

class ApplicationConfig {
    
    const APPLICATION_CONFIG_PROPERTY_NAME = 'applicationConfig'; 
    
    const TIME_ZONE_PROPERTY_NAME = 'timeZone';
    const STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_PROPERTY_NAME = 'startingOffsetInDaysOfScheduleForVisitors';
    const PHONE_PATTERN_PROPERTY_NAME = 'phonePattern';
    const MAKE_TIME_BUSY_ON_ORDER_PROPERTY_NAME = 'makeTimeBusyOnOrder';
    
    
    // Настройки по умолчаниию. 
    private static function defaultConfig() {
        return array (
            self::TIME_ZONE_PROPERTY_NAME => 'Europe/Moscow',
            self::STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_PROPERTY_NAME => 0,
            self::PHONE_PATTERN_PROPERTY_NAME => '^[0-9]{6,11}$',
            self::MAKE_TIME_BUSY_ON_ORDER_PROPERTY_NAME => true 
        );
    }
    
 
    private static $instance = null;
   
    private $state;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ApplicationConfig();
        }
        return self::$instance;
    }
    
    public function getAsArray() {
        try {
            $config =  $this->state->getProperty(self::APPLICATION_CONFIG_PROPERTY_NAME);
        } 
        catch (PropertyInApplicationStateNotDefindedException $e) {
            $config = $this->createDefaultConfig();
        }
        return $config;
    }
    
    public function setOnArray($configArray) {
        $this->state->setProperty(self::APPLICATION_CONFIG_PROPERTY_NAME, $configArray);
    }
    
    public function setOnModel($applicationConfigFormModel) {
        $config = array();
        $config[self::TIME_ZONE_PROPERTY_NAME] = $applicationConfigFormModel->timeZone;
        $config[self::STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_PROPERTY_NAME] = $applicationConfigFormModel->startingOffsetInDaysOfScheduleForVisitors;
        $config[self::PHONE_PATTERN_PROPERTY_NAME] = $applicationConfigFormModel->phonePattern;
        $config[self::MAKE_TIME_BUSY_ON_ORDER_PROPERTY_NAME] = $applicationConfigFormModel->makeTimeBusyOnOrder;
        $this->setOnArray($config);
    }
    
    public function setTimeZone($value) {
        $config = $this->getAsArray();
        $config[self::TIME_ZONE_PROPERTY_NAME] = $value;
        $this->setOnArray($config);
    }
    
    public function setStartingOffsetInDaysOfScheduleForVisitors($value) {
        $config = $this->getAsArray();
        $config[self::STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_PROPERTY_NAME] = $value;
        $this->setOnArray($config);
    }
    
    public function setPhonePattern($value) {
        $config = $this->getAsArray();
        $config[self::PHONE_PATTERN_PROPERTY_NAME] = $value;
        $this->setOnArray($config);
    }
    
    public function setMakeTimeBusyOnOrder($value) {
        $config = $this->getAsArray();
        $config[self::MAKE_TIME_BUSY_ON_ORDER_PROPERTY_NAME] = $value;
        $this->setOnArray($config);
    }
    
    public function getTimeZone() {
        $config = $this->getAsArray();
        return $config[self::TIME_ZONE_PROPERTY_NAME];
    }
    
    public function getStartingOffsetInDaysOfScheduleForVisitors() {
        $config = $this->getAsArray();
        return $config[self::STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_PROPERTY_NAME];
    }
    
    public function getPhonePattern() {
        $config = $this->getAsArray();
        return $config[self::PHONE_PATTERN_PROPERTY_NAME];
    }
    
    public function getMakeTimeBusyOnOrder() {
        $config = $this->getAsArray();
        return $config[self::MAKE_TIME_BUSY_ON_ORDER_PROPERTY_NAME];
    }
    
    // Используется когда произошло обращение к настройкам, а они ещё не заданы. 
    private function createDefaultConfig() {
        $defaultConfig = self::defaultConfig();
        $this->setOnArray($defaultConfig);
        return $defaultConfig;
    }
    
    private function __construct() {
        $this->state = ApplicationState::getInstance();
    }
    
}
