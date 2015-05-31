<?php

Yii::import('application.constant.validation.CommonConst');

class WorkDayConst {

    const DATE_PATTERN = CommonConst::DATE_DB_PATTERN;
    
    const DATE_REQUIERED_MSG = "Поле \"дата\" должно быть заполненно.";
    const DATE_IS_NOT_CORRECT_MSG = CommonConst::DATE_DB_IS_NOT_CORRECT_MSG;
    
    const PUBLISHED_REQUIERED_MSG = "Поле \"Опубликовано\" должно быть заполнено.";
    const PUBLISHED_IS_NOT_CORRECT_MSG = "Поле \"Опубликовано\" заполнено неверно.";
    
    const ID_SPECIALIZATION_REQUIERED_MSG = "\Поле \"Специализация\" должно быть заполненным.";
    const ID_SPECIALIZATION_IS_NOT_EXIST_MSG = 'Такой специализации не существует.';
    const ID_SPECIALIZATION_IS_NOT_CORRECT_MESSAGE = 'Id специализации должно быть положительным целым числом.';
    
    const WITH_THIS_SPECIALIZATION_ID_DOCTOR_REQUIERED_MSG = "Для этой специализации нужно указать врача.";
    const WITH_THIS_SPECIALIZATION_ID_DOCTOR_IS_NOT_REQUIERED_MSG = "Для этой специализации не нужно указывать врача.";
    const ID_DOCTOR_IS_NOT_CORRECT_MESSAGE = 'Id врача должно быть положительным целым числом.';
    const ID_DOCTOR_IS_NOT_EXIST_MSG = 'Такого врача не существует.';
    
    const DATE_ID_SPECIALIZATION_ID_DOCTOR_IS_NOT_UNIQUE = 'Дата, специализация и врач должны быть уникальными';
    
    private function __construct() {
       
    }
    
}