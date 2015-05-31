<?php


class SessionCounter {
    
    const COUNTERS_VAR_NAME_PREFIX = 'Counters';
    
    public static function inc($counterName) {
        $session = new CHttpSession;
        $session->open();
        
        $counterValue = $session->get(self::COUNTERS_VAR_NAME_PREFIX.$counterName, 0);
        ++$counterValue;
        $session->add(self::COUNTERS_VAR_NAME_PREFIX.$counterName, $counterValue);
    }
    
    public static function get($counterName) {
        $session = new CHttpSession;
        $session->open();
        
        return $session->get(self::COUNTERS_VAR_NAME_PREFIX.$counterName, 0);
    }
    
    public static function delete($counterName) {
        $session = new CHttpSession;
        $session->open();
        
        $session->remove(self::COUNTERS_VAR_NAME_PREFIX.$counterName);
    }
    
    private function __construct() {
            
    }
    
}
