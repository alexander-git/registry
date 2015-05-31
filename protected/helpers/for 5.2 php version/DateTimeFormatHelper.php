<?php

Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');

Yii::import('helpers.fix.FixedDateTime');

class DateTimeFormatHelper {
    
    const JS_DATE_TIME_FORMAT = 'j M Y H:i:s';
    const DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    const COMMON_DATE_TIME_FORMAT = 'd-m-Y H:i:s';
    
    public static function getDateTimeJSView($date) {
        return $date->format(self::JS_DATE_TIME_FORMAT);
    }
    
     
    public static function getDateTimeCommonTextView($date) {
        return $date->format(self::COMMON_DATE_TIME_FORMAT);
    }

    public static function getDateTimeDBView($date) {
        return $date->format(self::DB_DATE_TIME_FORMAT);
    }
    
    public static function getDateTimeFromDBView($dateTimeDBView) {
        $date = FixedDateTime::createFromFormat(self::DB_DATE_TIME_FORMAT, $dateTimeDBView);
        return $date;
    }
    
    public static function getDateTimeFromCommonTextView($dateTimeCommonTextView) {
        $date = FixedDateTime::createFromFormat(self::COMMON_DATE_TIME_FORMAT, $dateTimeCommonTextView);
        return $date;   
    }
    
    public static function dateTimeCommonTextViewToDateDBView($dateTimeCommonTextView) {
        $date = self::getDateTimeFromCommonTextView($dateTimeCommonTextView);
        return self::getDateTimeDBView($date);
    }
    
    public static function dateTimeDBViewToDateTimeCommonTextView($dateTimeDBView) {
        $date = self::getDateTimeFromDBView($dateTimeDBView);
        return self::getDateTimeCommonTextView($date);
    }
    
    public static function checkDateTimeInCommonTextView($dateTimeText) {
        $matches = array();
        if (!preg_match('/^([0-9]{2}-[0-9]{2}-[0-9]{4}) ([0-9]{2}:[0-9]{2}:[0-9]{2})$/isu', $dateTimeText, $matches) ) {
            return false;
        }
        $dateText = $matches[1];
        $timeText = $matches[2];
        $isDateCorrect = DateFormatHelper::checkDateInCommonTextView($dateText);
        $isTimeCorrect = TimeFormatHelper::checkTimeInCommonTextView($timeText);  
        return $isDateCorrect && $isTimeCorrect;
                     
    }
    
    
    private function __construct() {
         
    }
    
}