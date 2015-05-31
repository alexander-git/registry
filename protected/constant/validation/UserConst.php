<?php

Yii::import('constant.validation.CommonConst');

class UserConst {

    const NAME_MIN_LENGTH = 4;
    const NAME_MAX_LENGTH = 25;
    const NAME_PATTERN = "/^(?:[\p{L}\p{N}][\p{L}\p{N}\s_-]*[\p{L}\p{N}]|[\p{L}\p{N}]+)$/isu"; //"/^(?:[[:alnum:]][[:alnum:][:space:]_-]*[[:alnum:]]|[[:alnum:]]+)$/isu";
    
    const FIRSTNAME_MAX_LENGTH = CommonConst::FIRSTNAME_MAX_LENGTH;
    const SURNAME_MAX_LENGTH = CommonConst::SURNAME_MAX_LENGTH;
    const PATRONYMIC_MAX_LENGTH = CommonConst::PATRONIMYC_MAX_LENGTH;
    
    const FIRSTNAME_PATTERN = CommonConst::FIRSTNAME_PATTERN;
    const SURNAME_PATTERN = CommonConst::SURNAME_PATTERN;
    const PATRONYMIC_PATTERN  = CommonConst::PATRONYMIC_PATTERN; 
    
    const PASSWORD_MIN_LENGTH = 4;
    const PASSWORD_MAX_LENGTH = 100;
    
    const NAME_REQUIERED_MSG = 'Логин не должно быть пустым.';
    const NAME_TOO_SHORT_MSG = 'Длинна логина не должна быть меньше 4 символов.';
    const NAME_TOO_LONG_MSG = 'Длинна логина не должна быть больше 25 символов.';
    const NAME_IS_NOT_UNIQUE_MSG = 'Пользователь с таким логином уже существует.';
    const NAME_IS_NOT_CORRECT_MSG = 'Логин может содержать только буквы, цыфры, пробелы, дефис или подчёркивание. Оно должно начинаться и оканчиваться буквой или цифрой.';            
    
    const PASSWORD_REQUIERED_MSG = 'Пароль не должен быть пустым.';
    const PASSWORD_TOO_SHORT_MSG = 'Длинна пароля не должна быть меньше 4 символов.';
    const PASSWORD_TOO_LONG_MSG = 'Длинна пароля не должна быть больше 100 символов.';
    
    const FIRSTNAME_TOO_LONG_MSG = CommonConst::FIRSTNAME_TOO_LOGN_MSG;
    const FIRSTNAME_IS_NOT_CORRECT_MSG = CommonConst::FIRSTNAME_IS_NOT_CORRECT_MSG; 
    
    const SURNAME_TOO_LONG_MSG = CommonConst::SURNAME_TOO_LOGN_MSG;
    const SURNAME_IS_NOT_CORRECT_MSG = CommonConst::SURNAME_IS_NOT_CORRECT_MSG; 
    
    const PATRONYMIC_TOO_LONG_MSG = CommonConst::PATRONYMIC_TOO_LOGN_MSG;
    const PATRONYMIC_IS_NOT_CORRECT_MSG = CommonConst::PATRONYMIC_IS_NOT_CORRECT_MSG; 
     
    const ENABLED_REQUIERED_MSG = 'Состояние(включён/выключен) пользователя должно быть заданным.';
    const ENABLED_IS_NOT_CORRECT_MSG = 'Состояние(включён/выключен) пользователя задано не верно.';

    const ROLE_REQUIERED_MSG = 'Роль пользователся должна быть обязательно задана.';
    const ROLE_IS_NOT_CORRECT_MSG = 'Роль пользоватля задана неверно';
    
    private function __construct() {
       
    }
    
}