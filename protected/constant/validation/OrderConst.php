<?php

Yii::import('constant.validation.CommonConst');

class OrderConst {
      
    const DATE_PATTERN = CommonConst::DATE_DB_PATTERN;
    
    const TIME_PATTERN = CommonConst::TIME_DB_PATTERN;
    
    const ORDER_DATE_TIME_PATTERN = CommonConst::DATE_TIME_DB_PATTERN;
    
    const FIRSTNAME_MIN_LENGTH = 1;
    const FIRSTNAME_MAX_LENGTH = CommonConst::FIRSTNAME_MAX_LENGTH;
    const FIRSTNAME_PATTERN = CommonConst::FIRSTNAME_PATTERN;
    
    const SURNAME_MAX_LENGTH = CommonConst::SURNAME_MAX_LENGTH;
    const SURNAME_PATTERN = CommonConst::SURNAME_PATTERN;
    
    const PATRONIMYC_MAX_LENGTH = CommonConst::PATRONIMYC_MAX_LENGTH;
    const PATRONYMIC_PATTERN  = CommonConst::PATRONYMIC_PATTERN; 
    
    const PHONE_MIN_LENGTH = 1;
    const PHONE_MAX_LENGTH = 255;

    const ID_SPECIALIZATION_REQUIERED_MSG = 'Специализация должна быть указана.';
    const ID_SPECIALIZATION_IS_NOT_EXIST_MSG = 'Такой специализации не существует.';
    const ID_SPECIALIZATION_IS_NOT_CORRECT_MSG = 'Id специализации должно быть положительным целым числом.';
    
    const ID_DOCTOR_IS_NOT_CORRECT_MSG = 'Id врача должно быть положительным целым числом.';
    const ID_DOCTOR_IS_NOT_EXIST_MSG = 'Такого врача не существует.';
    
    const DATE_REQUIERED_MSG = 'Дата должна быть указана.';
    const DATE_IS_NOT_CORRECT_MSG = 'Неправильный формат даты.';
    
    const TIME_REQUIERED_MSG = 'Время должно быть указано.';
    const TIME_IS_NOT_CORRECT_MSG = 'Неправильный формат времени.';
    
    const ORDER_DATE_TIME_REQUIRED_MSG = 'Время заявки должно быть задано.';
    const ORDER_DATE_TIME_IS_NOT_CORRECT_MSG = 'Время заявки задано неверно.';
    
    const FIRSTNAME_REQUIERED_MSG = 'Нужно ввести имя.';
    const FIRSTNAME_TOO_SHORT_MSG = 'Имя слишком короткое.';
    const FIRSTNAME_TOO_LONG_MSG = 'Имя слишком длинное.';
    const FIRSTNAME_IS_NOT_CORRECT_MSG = 'Недопустимое имя.'; 
   
    const SURNAME_TOO_LONG_MSG = 'Фамилия слишком длинная.';
    const SURNAME_IS_NOT_CORRECT_MSG = 'Недопустимая фамилия.'; 
    
    const PATRONYMIC_TOO_LONG_MSG = 'Отчество слишком длинное.';
    const PATRONYMIC_IS_NOT_CORRECT_MSG = 'Недопустимое отчество.';
    
    const PHONE_REQUIERED_MSG = 'Нужно ввести номер телефона.';
    const PHONE_TOO_SHORT_MSG = 'Телефон слишком короткий.';
    const PHONE_TOO_LONG_MSG = 'Телефон слишком длинный.';
    const PHONE_IS_NOT_CORRECT_MSG = 'Недопустимый номер телефона.';
    
    const PROCESSED_REQUIERED_MSG = "Поле \"Обработана\" должно быть заполнено.";
    const PROCESSED_IS_NOT_CORRECT_MSG = "Поле \"Обработана\" заполнено неверно.";
    
    const STATE_REQUIRED_MSG = "Поле \"Состояние\" должно быть заполнено.";
    const STATE_IS_NOT_CORRECT_MSG = "Поле \"Состояние\" заполнено не верно."; 
            
    private function __construct() {
       
    }
    
}