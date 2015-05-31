<?php

class ConvertHelper {

    const BOOLEAN_VALUE_NOT_CORRECT_EXCEPTION_MESSAGE = 'Значение должно быть либо true либо false.';
    
    public static function booleanToOneOrZero($value) {
        if ($value === true) {
            return 1;
        } else if ($value === false) {
            return 0;
        } else {
            throw new Exception(self::BOOLEAN_VALUE_NOT_CORRECT_EXCEPTION_MESSAGE);
        }
    }
    
    private function __construct() {
     
    }
    
}
