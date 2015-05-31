<?php

class ApplicationConfigFormConst {
    
    const TIME_ZONE_MIN_LENGTH = 1;
    const TIME_ZONE_MAX_LENGTH = 255;
    
    const TIME_ZONE_REQUIERED_MSG = "Поле \"Временная зона\" должно быть заполнено.";
    const TIME_ZONE_TOO_SHORT_MSG = "Поле \"Временная зона\" должно содержать минимум 1 символ.";
    const TIME_ZONE_TOO_LONG_MSG = "Поле \"Временная зона\" должно содержать максимум 255 символов.";
    
    const STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_REQUIERED_MSG = "Поле \"Начальное смещение расписания в днях для посетителей сайта\" должно быть заполнено.";
    const STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_IS_NOT_CORRECT_MSG = "\"Начальное смещение расписания в днях для посетителей сайта\" должно быть целым числом";
    
    const MAKE_TIME_BUSY_ON_OREDR_REQUIERED_MSG = "Поле \"Устанавливать время занятым когда пользователь делает заявку\" должно быть заполнено.";
    const MAKE_TIME_BUSY_ON_OREDR_IS_NOT_CORRECT_MSG = "Поле \"Устанавливать время занятым когда пользователь делает заявку\" заполнено неправильно.";
    
    private function __construct() {
        
    }
    
}
