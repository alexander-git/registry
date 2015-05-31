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
        $time = DateTime::createFromFormat(self::COMMON_TIME_FORMAT, $timeCommonTextView);
        return self::getTimeDBView($time);
    }
    
    public static function timeCommonTextViewToTimeShortTextView($timeCommonTextView) {
        $time = DateTime::createFromFormat(self::COMMON_TIME_FORMAT, $timeCommonTextView);
        return self::getTimeShortTextView($time);
    }
    
    public static function timeCommonTextViewToTimeUrlView($timeCommonTextView) {
        $time = DateTime::createFromFormat(self::COMMON_TIME_FORMAT, $timeCommonTextView);
        return self::getTimeUrlView($time);
    }
    
    public static function timeDBViewToTimeCommonTextView($timeDBView) {
        $time = DateTime::createFromFormat(self::DB_TIME_FORMAT, $timeDBView);
        return self::getTimeCommonTextView($time);
    }
    
    public static function timeDBViewToTimeShortTextView($timeDBTextView) {
        $time = DateTime::createFromFormat(self::DB_TIME_FORMAT, $timeDBTextView);
        return self::getTimeShortTextView($time);
    }
    
    public static function timeDBViewToTimeUrlView($timeDBTextView) {
        $time = DateTime::createFromFormat(self::DB_TIME_FORMAT, $timeDBTextView);
        return self::getTimeUrlView($time);
    }
    
    public static function timeShortTextViewToTimeCommonTextView($timeShortTextView) {
        $time = DateTime::createFromFormat(self::SHORT_TIME_FORMAT, $timeShortTextView);
        return self::getTimeCommonTextView($time); 
    }
    
    public static function timeShortTextViewToTimeDBView($timeShortTextView) {
        $time = DateTime::createFromFormat(self::SHORT_TIME_FORMAT, $timeShortTextView);
        return self::getTimeDBView($time); 
    }
    
    public static function timeShortTextViewToTimeUrlView($timeShortTextView) {
        $time = DateTime::createFromFormat(self::SHORT_TIME_FORMAT, $timeShortTextView);
        return self::getTimeUrlView($time);
    }
    
    public static function timeUrlViewToTimeCommonTextView($timeUrlView) {
        $time = DateTime::createFromFormat(self::URL_TIME_FORMAT, $timeUrlView);
        return self::getTimeCommonTextView($time); 
    }
    
    public static function timeUrlViewToTimeDBTextView($timeUrlView) {
        $time = DateTime::createFromFormat(self::URL_TIME_FORMAT, $timeUrlView);
        return self::getTimeDBView($time);
    }
    
    public static function timeUrlViewViewToTimeShortTextView($timeUrlView) {
        $time = DateTime::createFromFormat(self::URL_TIME_FORMAT, $timeUrlView);
        return self::getTimeShortTextView($time); 
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
        
    private function __construct() {
         
    }
    
}