<?php

Yii::import('application.constant.validation.CommonConst');

class SpecializationConst {
    
    const NAME_MIN_LENGTH = CommonConst::ENTITY_NAME_MIN_LENGTH;
    const NAME_MAX_LENGTH = CommonConst::ENTITY_NAME_MAX_LENGTH;
    const NAME_PATTERN = CommonConst::ENTITY_NAME_PATTERN;  
  
    const ADDTIONAL_MAX_LENGTH = CommonConst::ADDITIONAL_MAX_LENGTH;
    
    const NAME_REQUIERED_MSG = CommonConst::ENTITY_NAME_REQUIERED_MESSAGE;
    const NAME_TOO_SHORT_MSG = CommonConst::ENTITY_NAME_TOO_SHORT_MSG;
    const NAME_TOO_LONG_MSG = CommonConst::ENTITY_NAME_TOO_LONG_MSG;
    const NAME_IS_NOT_CORRECT_MSG = CommonConst::ENTITY_NAME_IS_NOT_CORRECT_MSG;            
    
    const NAME_ADDITIONAL_IS_NOT_UNIQUE_MSG = "Спецализации с таким именем и значением поля \"Дополнительно\" уже существует.\n Измените либо имя специализации либо значение поля \"Дополнительно\".";
    
    const ADDITIONAL_TOO_LONG_MSG = CommonConst::ADDITIONAL_TOO_LONG_MSG;
    
    const ENABLED_REQUIERED_MSG = 'Состояние(включёна/выключена) специализации должно быть заданным.';
    const ENABLED_IS_NOT_CORRECT_MSG = 'Состояние(включёна/выключена) специализации заданно не верно.';
    
    const NEED_DOCTOR_REQUIERED_MSG = 'Поле "Указывать врачей" должно быть заполнено';
    const NEED_DOCTOR_IS_NOT_CORRECT_MSG = 'Поле "Указывать врачей" заполнено не верно';
    
    const RECORD_ON_TIME_REQUIERED_MSG = 'Поле "Запись на время" должно быть заполнено';
    const RECORD_ON_TIME_IS_NOT_CORRECT_MSG = 'Поле "Запись по времени" заполнено не верно';
    
    const PROVISIONAL_RECORD_REQUIERED_MSG = 'Поле "Предварительная запись" должно быть заполнено';
    const PROVISIONAL_RECORD_IS_NOT_CORRECT_MSG = 'Поле "Предварительная запись" заполнено не верно';
   
    const ID_GROUP_IS_NOT_CORRECT_MSG = 'id группы должно быть целым положительным числом';
    const ID_GROUP_IS_NOT_EXIST_MSG = 'Такой группы не существует';
    
    private function __construct() {
       
    }
}
