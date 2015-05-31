<?php

class TimeFormatHelper {
   
    const COMMON_TIME_FORMAT = 'H:i:s';
    const DB_TIME_FORMAT = 'H:i:s';
    const SHORT_TIME_FORMAT = 'H:i';
    const URL_TIME_FORMAT = 'H-i'; // Так как в url нельзя использовать двоеточие, то заменяем его на тире.
    
    public static function getTimeCommonTextiew($time) {
        return $time->format(self::COMMON_TIME_FORMAT);
    }
    
    public static function getTimeDBView($time) {
        return $time->format(self::DB_TIME_FORMAT);
    }

    public static function getTimeShortTextView($time) {
        return $time->format(self::SHORT_TIME_FORMAT);
    }
    
    public static function getTimeUrlView($time) {
        return $time->format(self::URL_TIME_FORMAT);
    }
   
    public static function timeCommonTextViewToTimeDBView($timeCommonTextView) {
        $timeParts = self::getTimePartsFromTimeCommonTextView($timeCommonTextView);
        return self::createTimeDBView($timeParts['hours'], $timeParts['minutes'], $timeParts['seconds']);
    }
    
    public static function timeCommonTextViewToTimeShortTextView($timeCommonTextView) {
        $timeParts = self::getTimePartsFromTimeCommonTextView($timeCommonTextView);
        return self::createTimeShortTextView($timeParts['hours'], $timeParts['minutes']);
    }
    
    public static function timeCommonTextViewToTimeUrlView($timeCommonTextView) {
        $timeParts = self::getTimePartsFromTimeCommonTextView($timeCommonTextView);
        return self::createTimeUrlView($timeParts['hours'], $timeParts['minutes']);
    }
    
    
    public static function timeDBViewToTimeCommonTextView($timeDBView) {
        $timeParts = self::getTimePartsFromTimeDBView($timeDBView);
        return self::createTimeCommonTextView($timeParts['hours'], $timeParts['minutes'], $timeParts['seconds']);
    }
    
    public static function timeDBViewToTimeShortTextView($timeDBView) {
        $timeParts = self::getTimePartsFromTimeDBView($timeDBView);
        return self::createTimeShortTextView($timeParts['hours'], $timeParts['minutes']);
    }
    
    public static function timeDBViewToTimeUrlView($timeDBView) {
        $timeParts = self::getTimePartsFromTimeDBView($timeDBView);
        return self::createTimeUrlView($timeParts['hours'], $timeParts['minutes']);
    }
    
    
    public static function timeShortTextViewToTimeCommonTextView($timeShortTextView) {
        $timeParts = self::getTimePartsFromTimeShortTextView($timeShortTextView);
        return self::createTimeCommonTextView($timeParts['hours'], $timeParts['minutes'], 0);
    }
    
    public static function timeShortTextViewToTimeDBView($timeShortTextView) {
        $timeParts = self::getTimePartsFromTimeShortTextView($timeShortTextView);
        return self::createTimeDBView($timeParts['hours'], $timeParts['minutes'], 0); 
    }
    
    public static function timeShortTextViewToTimeUrlView($timeShortTextView) {
        $timeParts = self::getTimePartsFromTimeShortTextView($timeShortTextView);
        return self::createTimeUrlView($timeParts['hours'], $timeParts['minutes']);
    }
    
    public static function timeUrlViewToTimeCommonTextView($timeUrlView) {
        $timeParts = self::getTimePartsFromTimeUrlView($timeUrlView);
        return self::createTimeCommonTextView($timeParts['hours'], $timeParts['minutes'], 0);
    }
    
    public static function timeUrlViewToTimeDBTextView($timeUrlView) {
        $timeParts = self::getTimePartsFromTimeUrlView($timeUrlView);
        return self::createTimeDBView($timeParts['hours'], $timeParts['minutes'], 0);
    }
    
    public static function timeUrlViewViewToTimeShortTextView($timeUrlView) {
        $timeParts = self::getTimePartsFromTimeUrlView($timeUrlView);
        return self::createTimeShortTextView($timeParts['hours'], $timeParts['minutes']);
    }
    
    public static function checkTimeInCommonTextView($dateText) {
        $matches = array();
        if (!preg_match('/^([0-9]{2}):([0-9]{2}):([0-9]{2})$/isu', $dateText, $matches) ) {
            return false;
        }
        $hours = $matches[1];
        $minutes = $matches[2];
        $seconds = $matches[3];
        
        return self::areHoursCorrect($hours) && 
               self::areMinutesCorrect($minutes) &&
               self::areSecondsCorrect($seconds);
    }
    
    public static function checkTimeInShortTextView($dateText) {
        $matches = array();
        if (!preg_match('/^([0-9]{2}):([0-9]{2})$/isu', $dateText, $matches) ) {
            return false;
        }
        $hours = $matches[1];
        $minutes = $matches[2];
        
        return self::areHoursCorrect($hours) && 
               self::areMinutesCorrect($minutes);
    }
     
    public static function checkTimeInUrlView($dateText) {
        $matches = array();
        if (!preg_match('/^([0-9]{2})-([0-9]{2})$/isu', $dateText, $matches) ) {
            return false;
        }
        $hours = $matches[1];
        $minutes = $matches[2];
        
        return self::areHoursCorrect($hours) && 
               self::areMinutesCorrect($minutes);
    }
    
    private static function areHoursCorrect($hoursStr) {
        $hoursValue = null;
        if ($hoursStr[0] === '0') {
            $hoursValue = intval($hoursStr[1]);
        } else {
            $hoursValue = intval($hoursStr);
        }
        
        if ($hoursValue < 0 || $hoursValue > 23) {
            return false;    
        } else {
            return true;
        }
    }
    
    private static function areMinutesCorrect($minutesStr) {
        $minutesValue = null;
        if ($minutesStr[0] === '0') {
            $minutesValue = intval($minutesStr[1]);
        } else {
            $minutesValue = intval($minutesStr);
        }
         if ($minutesValue < 0 || $minutesValue > 59) {
            return false;    
        } else {
            return true;
        }
    }
    
    private static function areSecondsCorrect($secondsStr) {
        $secondsValue = null;
        if ($secondsStr[0] === '0') {
            $secondsValue = intval($secondsStr[1]);
        } else {
            $secondsValue = intval($secondsStr);
        }
        
        if ($secondsValue < 0 || $secondsValue > 59) {
            return false;    
        } else {
            return true;
        }
    }
    
    private static function getTimePartsFromTimeCommonTextView($timeCommonTextView) {
        $hoursStr = substr($timeCommonTextView, 0, 2);
        $minutesStr = substr($timeCommonTextView, 3, 2);
        $secondsStr = substr($timeCommonTextView, 6, 2); 
        
        $result = array();
        $result['hours'] = self::getIntValueFromTwoSymbolsStr($hoursStr);
        $result['minutes'] = self::getIntValueFromTwoSymbolsStr($minutesStr);
        $result['seconds'] = self::getIntValueFromTwoSymbolsStr($secondsStr);

        return $result;
    }
    
    private static function getTimePartsFromTimeDBView($timeDBView) {
        $hoursStr = substr($timeDBView, 0, 2);
        $minutesStr = substr($timeDBView, 3, 2);
        $secondsStr = substr($timeDBView, 6, 2); 
        
        $result = array();
        $result['hours'] = self::getIntValueFromTwoSymbolsStr($hoursStr);
        $result['minutes'] = self::getIntValueFromTwoSymbolsStr($minutesStr);
        $result['seconds'] = self::getIntValueFromTwoSymbolsStr($secondsStr);

        return $result;
    }
    
    private static function getTimePartsFromTimeShortTextView($timeShortTextView) {
        $hoursStr = substr($timeShortTextView, 0, 2);
        $minutesStr = substr($timeShortTextView, 3, 2);

        $result = array();
        $result['hours'] = self::getIntValueFromTwoSymbolsStr($hoursStr);
        $result['minutes'] = self::getIntValueFromTwoSymbolsStr($minutesStr);
        
        return $result;
    }
    
    private static function getTimePartsFromTimeUrlView($timeUrlView) {
        $hoursStr = substr($timeUrlView, 0, 2);
        $minutesStr = substr($timeUrlView, 3, 2);

        $result = array();
        $result['hours'] = self::getIntValueFromTwoSymbolsStr($hoursStr);
        $result['minutes'] = self::getIntValueFromTwoSymbolsStr($minutesStr);
        
        return $result;
    }
    
    
    private static function createTimeCommonTextView($hours, $minutes, $seconds) {
        $result = self::getTwoSymboslStrFromIntValue($hours);
        $result .= ':';
        $result .= self::getTwoSymboslStrFromIntValue($minutes);
        $result .= ':';
        $result .= self::getTwoSymboslStrFromIntValue($seconds);
        
        return $result;
    }
    
    private static function createTimeDBView($hours, $minutes, $seconds) {
        $result = self::getTwoSymboslStrFromIntValue($hours);
        $result .= ':';
        $result .= self::getTwoSymboslStrFromIntValue($minutes);
        $result .= ':';
        $result .= self::getTwoSymboslStrFromIntValue($seconds);
        
        return $result;
    }
    
    private static function createTimeShortTextView($hours, $minutes) {
        $result = self::getTwoSymboslStrFromIntValue($hours);
        $result .= ':';
        $result .= self::getTwoSymboslStrFromIntValue($minutes);

        return $result;
    }
    
    private static function createTimeUrlView($hours, $minutes) {
        $result = self::getTwoSymboslStrFromIntValue($hours);
        $result .= '-';
        $result .= self::getTwoSymboslStrFromIntValue($minutes);
        
        return $result;
    }
    
    
    private static function getIntValueFromTwoSymbolsStr($str) {
        if ($str[0] === '0') {
            return intval($str[1]);
        } else {
            return intval($str);
        }
    }
    
    private static function getTwoSymboslStrFromIntValue($value) {
        if ($value < 10) {
            return '0'.strval($value);
        } else {
            return strval($value);
        }
    }
        
    private function __construct() {
         
    }
    
}