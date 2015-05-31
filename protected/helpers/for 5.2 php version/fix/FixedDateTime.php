<?php

// Используется некоторыми helper-ами для поддержки работоспособности 
// в версии php 5.2, т.к. там функция DateTime::createFromFormat ещё
// не присутствует. В версии php 5.3 и выше этот класс не нужен, хотя он будет
// правильно работать и там. Функция проверяет версиию php и если там есть метод
// DateTime::createFromFormat, то будет  использоваться именно он. Иначе
// будет испоьзоваться другой способ.  Т.к. в этом случае задействуется
// timeStamp, то правильно, в отличии от createFromFormat из php >= 5.3, 
// функция будет работать лишь со временем в определённых пределах. 
// Также, разумеется, функция не будет работать правильно если в качестве 
// аргументов($format или $dateTimeStr) передаются значения предполагающие
// наличие только часов/минут/секунд, но не содержащие года/месяца/дня, в 
// отличии от оригинальной версии DateTime::createFromFormat.

class FixedDateTime extends DateTime
{
    public static function createFromFormat($format, $dateTimeStr, $timezone = null)
    {
        if($timezone === null) {
            $timezone = new DateTimeZone(date_default_timezone_get() );
        }
        
        $version = explode('.', phpversion());
        if( ( intval($version[0]) >= 5 && intval($version[1]) >= 2 && intval($version[2]) > 17) ) {
            return parent::createFromFormat($format, $dateTimeStr, $timezone);
        }
        
        $timeStamp = strtotime($dateTimeStr);
        return new DateTime(date($format, $timeStamp), $timezone);
    }
}