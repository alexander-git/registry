<?php

class DateFormatHelper {
    
    const COMMON_DATE_FORMAT = 'd-m-Y';
    const DB_DATE_FORMAT = 'Y-m-d'; 
   
    private static $EnToRusDaysOfWeekShortNames = array(
        'Mon' => 'Пн',
        'Tue' => 'Вт',
        'Wed' => 'Ср',
        'Thu' => 'Чт',
        'Fri' => 'Пт',
        'Sat' => 'Сб',
        'Sun' => 'Вс',
    );
    
    private static $EnToRusDaysOfWeekLongNames = array(
        'Monday' => 'Понедельник',
        'Tuesday' => 'Вторник',
        'Wednesday' => 'Среда',
        'Thursday' => 'Четверг',
        'Friday' => 'Пятница',
        'Saturday' => 'Суббота',
        'Sunday' => 'Воскресенье',
    );
    
     private static $mounthNumberToRussianTextViewsWithEndings = array(
        1 => 'Января',
        2 => 'Февраля',
        3 => 'Марта',
        4 => 'Апреля',
        5 => 'Мая',
        6 => 'Июня',
        7 => 'Июля',
        8 => 'Августа',
        9 => 'Сентября',
        10 => 'Октября',
        11 => 'Ноября',
        12 => 'Декабря',
    );
    
    public static function getRussianDayOfWeekShortName($date) {
        $EnWeekOfDayShortName = $date->format("D");
        return self::$EnToRusDaysOfWeekShortNames[$EnWeekOfDayShortName];
    }
     
    public static function getRussianDayOfWeekLongName($date) {
        $EnWeekOfDayLongName = $date->format("l");
        return self::$EnToRusDaysOfWeekLongNames[$EnWeekOfDayLongName];
    }
    
    public static function getRussianMounthNameWithEnding($date) {
        $mounthNumber = $date->format('n');
        return self::$mounthNumberToRussianTextViewsWithEndings[$mounthNumber];
    }
    
    public static function getDateTextViewWithRussianMounth($date) {
        $mounthNumber = $date->format('n');
        $mounth = self::$mounthNumberToRussianTextViewsWithEndings[$mounthNumber];
        return $date->format('j')." $mounth ".$date->format('Y');
    }
    
    public static function getDateCommonTextView($date) {
        return $date->format(self::COMMON_DATE_FORMAT);
    }
    
    public static function getDateDBView($date) {
        return $date->format(self::DB_DATE_FORMAT);
    }
    
    public static function dateCommonTextViewToDateDBView($dateCommonTextView) {
        $date = self::getDateFromCommonTextView($dateCommonTextView); 
        return self::getDateDBView($date);
    }
    
    public static function dateDBViewToDateCommonTextView($dateDBView) {
        $date = self::getDateFromDBView($dateDBView);
        return self::getDateCommonTextView($date);
    }
    
    public static function getDateFromCommonTextView($dateCommonTextView) {
        $date = DateTime::createFromFormat(self::COMMON_DATE_FORMAT, $dateCommonTextView);
        $date->setTime(0, 0, 0);
        return $date;
    }
    
    public static function getDateFromDBView($dateDBView) {
        $date = DateTime::createFromFormat(self::DB_DATE_FORMAT, $dateDBView);
        $date->setTime(0, 0, 0);
        return $date;
    }
    
   
    public static function getDateScheduleHeadCellTextView($date) {
        $day = $date->format("j");
        $dayOfWeek = self::getRussianDayOfWeekShortName($date);
        $dateStr = $day."\n<br />".$dayOfWeek;
        
        return $dateStr;
    }
    
    public static function getDayNumberAndRussianMounthNameWithEndingTextView($date) {
        $day = $date->format("j");
        $mounth = self::getRussianMounthNameWithEnding($date);
        $dateStr = "$day $mounth";
        
        return $dateStr;
    }
    
    public static function getDayRussianMounthYearDateTextView($date) {
        $day = $date->format("j");
        $mounth = self::getRussianMounthNameWithEnding($date);
        $year = $date->format("Y");
        $dateStr = "$day $mounth $year";
        
        return $dateStr;
    }
    
    public static function getIntervalOfDatesTextView($beginDate, $endDate) {
        $beginDateText = self::getDateTextViewWithRussianMounth($beginDate);
        $endDateText = self::getDateTextViewWithRussianMounth($endDate);
        return "С $beginDateText \n<br /> По $endDateText";
    }
    
    public static function getCopyOfDateWithResetTime($date) {
        $copy = self::getCopyOfDate($date);
        $copy->setTime(0, 0, 0);
        return $copy;
    }
    
    public static function getCopyOfDate($date) {
        $f = 'd-m-Y H:i:s';
        $copy = DateTime::createFromFormat($f, $date->format($f) );
        return $copy;
    }
    
    public static function shiftDateForSeveralDays($date, $numberOfDays) {
        // Код, который работает в любой версии php >= 5.2
        $copy = self::getCopyOfDate($date);
        if ($numberOfDays > 0) {
            $copy->modify(" +$numberOfDays day");
        } else if ($numberOfDays < 0) {
            $numberOfDaysAbs = abs($numberOfDays);
            $copy->modify(" -$numberOfDaysAbs day");
        } else {
            // $numberOfDays === 0 - ничего не меняем.
        }
        return $copy;
        
        
        /*
        // Первоночально написанный код для весии php >= 5.3
        $copy = self::getCopyOfDate($date);
        $interval = new DateInterval('P'.abs($numberOfDays).'D');
        if ($numberOfDays >= 0) {
            $d = $copy->add($interval);
        } else {
            $d = $copy->sub($interval);
        }
        return $d;
        */
    }
    
    public static function checkDateInCommonTextView($dateText) {
        $matches = array();
        if (!preg_match('/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/isu', $dateText, $matches) ) {
            return false;
        }
        $day = $matches[1];
        $month = $matches[2];
        $year = $matches[3];
        
        return checkdate($month, $day, $year);
    }
    
    private function __construct() {
         
    }
    
}