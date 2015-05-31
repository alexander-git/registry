<?php

class OutHelper {
    
    public static function insertSpacesBetweenValues() {
        $args = func_get_args();
        $values = self::getValuesFromArgs($args);
        return self::insertDelimiterBetweenValues($values, ' ');
    }
    
    public static function insertBrBetweenValues() {
        $args = func_get_args();
        $values = self::getValuesFromArgs($args);
        
        return self::insertDelimiterBetweenValues($values, "<br/>\n");
    }
    
    public static function isEmpty ($value) {
         return ($value === null) || (trim($value) === '');
    }
    
    public static function  surroundWithBrackets($value) {
        return '('.$value.')';
    }
    
    private static function getValuesFromArgs($args) {
        $values = null;
        if (is_array($args[0]) ) {
            $values = $args[0];
        } else {
            $values = $args;
        }
        return $values;
    }
    
    private static function insertDelimiterBetweenValues($values, $delimiter) {
        $result = '';
        foreach ($values as $v) {
            if (self::isEmpty($v) ) {
                continue;
            } 
            if ($result !== '') {
                $result .= $delimiter;
            }
            $result .= $v;
        }
        
        return $result;
    }
    
    private function __construct() {
         
    }
       
}