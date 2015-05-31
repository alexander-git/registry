<?php


class CommonConst {
    
    const ENTITY_NAME_PATTERN = "/^(?:\S.*\S|\S+)$/isu";
    const ENTITY_NAME_MIN_LENGTH = 1;
    const ENTITY_NAME_MAX_LENGTH = 255;
    const ENTITY_NAME_REQUIERED_MESSAGE = 'Имя не должно быть пустым.';
    const ENTITY_NAME_IS_NOT_CORRECT_MSG = 'Имя не должно начинаться или оканчиваться пробелом.'; 
    const ENTITY_NAME_TOO_SHORT_MSG = 'Длинна имени не должна быть меньше 1 символа.';
    const ENTITY_NAME_TOO_LONG_MSG = 'Длинна имени не должна быть больше 255 символов.'; 
    
    const ADDITIONAL_MAX_LENGTH = 255;
    const ADDITIONAL_TOO_LONG_MSG = "Длинна поля \"Дополнительно\" не должна быть больше 255 символов."; 
    
    const FIRSTNAME_PATTERN = "/^(?:\p{L}[\p{L}\s-\.]*[\p{L}\.]|\p{L}+)$/isu";//"/^([[:alpha:]][[:alpha:][:space:]-]*[[:alpha:]]|[[:alpha:]]+)$/isu";
    const SURNAME_PATTERN = self::FIRSTNAME_PATTERN;
    const PATRONYMIC_PATTERN  = self::FIRSTNAME_PATTERN; 
    
    const FIRSTNAME_MAX_LENGTH = 255;
    const SURNAME_MAX_LENGTH = self::FIRSTNAME_MAX_LENGTH;
    const PATRONIMYC_MAX_LENGTH = self::FIRSTNAME_MAX_LENGTH;
    
    const FIRSTNAME_TOO_LOGN_MSG = 'Длинна имени не должна быть больше 255 символов';
    const SURNAME_TOO_LOGN_MSG = 'Длинна фамилии не должна быть больше 255 символов';
    const PATRONYMIC_TOO_LOGN_MSG = 'Длинна отчества не должна быть больше 255 символов';
    
    const FIRSTNAME_IS_NOT_CORRECT_MSG = 'Имя может содержать только буквы , пробелы или дефис. Оно должно начинаться и оканчиваться буквой.'; 
    const SURNAME_IS_NOT_CORRECT_MSG = 'Фамилия может содержать только буквы, пробелы или дефис. Она должно начинаться и оканчиваться буквой.';
    const PATRONYMIC_IS_NOT_CORRECT_MSG = 'Отчество может содержать только буквы, пробелы или дефис. Оно должно начинаться и оканчиваться буквой.';
    
    const DATE_DB_PATTERN = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/isu";
    const DATE_DB_IS_NOT_CORRECT_MSG = "Дата задана неверно.";
    
    const TIME_DB_PATTERN = "/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/isu";
    const TIME_DB_IS_NOT_CORRECT_MSG = 'Время задано неверно.';
    
    const DATE_TIME_DB_PATTERN = "/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/isu";
    const DATE_TIME_DB_IS_NOT_CORRECT_MSG = "Дата задана неверно.";
     
    private function __construct() {
        
    }
    
}
