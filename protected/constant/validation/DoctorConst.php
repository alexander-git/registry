<?php

Yii::import('application.constant.validation.CommonConst');

class DoctorConst {
    
    const FIRSTNAME_MIN_LENGTH = 1;
    
    const FIRSTNAME_MAX_LENGTH = CommonConst::FIRSTNAME_MAX_LENGTH;
    const SURNAME_MAX_LENGTH = CommonConst::SURNAME_MAX_LENGTH;
    const PATRONIMYC_MAX_LENGTH = CommonConst::PATRONIMYC_MAX_LENGTH;
    
    const ADDITIONAL_MAX_LENGTH = CommonConst::ADDITIONAL_MAX_LENGTH;
    
    const SPECIALITY_MIN_LENGTH = 1;
    const SPECIALITY_MAX_LENGTH = 255;
    const INFO_MAX_LENGTH = 65535;
    
   
    const FIRSTNAME_PATTERN = CommonConst::FIRSTNAME_PATTERN;
    const SURNAME_PATTERN = CommonConst::SURNAME_PATTERN;
    const PATRONYMIC_PATTERN  = CommonConst::PATRONYMIC_PATTERN; 
    
    const SPECIALITY_PATTERN = "/^(?:\S.*\S|\S+)$/isu";

    const FIRSTNAME_REQUIERED_MSG = 'Имя должно быть задано.';
    const SURNAME_REQUIERED_MSG = 'Фамилия должна быть задана.';
    
    const FIRSTNAME_TOO_SHORT_MSG = 'Длинна имени не должна быть меньше 1 символа.';
    const FIRSTNAME_TOO_LONG_MSG = CommonConst::FIRSTNAME_TOO_LOGN_MSG;
    const SURNAME_TOO_LONG_MSG = CommonConst::SURNAME_TOO_LOGN_MSG;
    const PATRONYMIC_TOO_LONG_MSG = CommonConst::PATRONYMIC_TOO_LOGN_MSG;
    
    const FIRSTNAME_IS_NOT_CORRECT_MSG = CommonConst::FIRSTNAME_IS_NOT_CORRECT_MSG; 
    const SURNAME_IS_NOT_CORRECT_MSG = CommonConst::SURNAME_IS_NOT_CORRECT_MSG; 
    const PATRONYMIC_IS_NOT_CORRECT_MSG = CommonConst::PATRONYMIC_IS_NOT_CORRECT_MSG;
    
    const ADDITIONAL_TOO_LONG_MSG = CommonConst::ADDITIONAL_TOO_LONG_MSG;
    const FIRSTNAME_SURNAME_PATRONYMIC_ADDITIONAL_IS_NOT_UNIQUE_MSG = "Врач с таким именем, фамилией, отчеством и значением поля \"Дополнительно\" уже существует.\n Измените что-либо, чтобы это сочетание было уникальным.";
   
    const ENABLED_REQUIERED_MSG = 'Состояние(включён/выключен) врача должно быть заданным.';
    const ENABLED_IS_NOT_CORRECT_MSG = 'Состояние(включён/выключен) врача задано не верно.';
    
    const SPECIALITY_REQUIRED_MSG = "Поле \"Специальность\" должно быть заполнено.";
    const SPECIALITY_TOO_SHORT_MSG = 'Длинна специальности не должна быть меньше 1 символа.';
    const SPECIALITY_TOO_LONG_MSG = 'Длинна специальности не должна быть больше 255 символов';
    const SPECIALITY_IS_NOT_CORRECT_MSG = "Поле \"Специальность\" не должно начинаться или оканчиваться пробелом.";
    
    const INFO_TOO_LONG_MSG = 'Длинна не должа быть больше 65535 символов';
  
    private function __construct() {
       
    }
    
}