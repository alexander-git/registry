<?php

class AjaxParseHelper {

    const BOOLEAN_FORMAT_NOT_CORRECT_EXCEPTION_MESSAGE = "Значение должно быть либо строкой \"true\" либо строкой \"false\".";

    public static function getBoolean($value) {
        if ($value === 'true') {
            return true;
        } else if ($value === 'false') {
            return false;
        } else {
            throw new Exception(self::BOOLEAN_FORMAT_NOT_CORRECT_EXCEPTION_MESSAGE);
        }
    }
    
    public static function getInteger($value) {
        return intval($value);
    }
    
    public static function getIntegerOrNull($value) {
        if ($value === '') {
            return null;
        } else {
            return self::getInteger($value);
        }
    }

    private function __construct() {
    
        
    }
    
}