<?php

class JsonHelper {
    
    public static function prepareIntegerToEncode($value) {
        return intval($value);
    }
    
    public static function prepareIntegerOrNullToEncode($value) {
        if ($value !== null) {
            return self::prepareIntegerToEncode($value);
        } else {
            return null;
        }
    }
    
    public static function prepareBooleanToEncode($value) {
        if ($value) {
            return true;
        } else {
            return false;
        } 
    }
    
    public static function prepareBooleanOrNullToEncode($value) {
        if ($value !== null) {
            return self::prepareBooleanToEncode($value);
        } else {
            return null;
        }
    }
    
    private function __construct() {
    
    }
    
}