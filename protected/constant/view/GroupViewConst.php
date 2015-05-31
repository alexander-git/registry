<?php

class GroupViewConst {
    
    const ENABLED_TRUE_TEXT = 'Включёна';
    const ENABLED_FALSE_TEXT = 'Отключена';
    
    
    public static function getEnabledTextView($enabled) {
        if ($enabled) {
            return self::ENABLED_TRUE_TEXT;
        } else {
            return self::ENABLED_FALSE_TEXT;
        }
    }
    
    private function __construct() {
    
    }
    
}
