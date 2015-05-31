<?php

Yii::import('application.constant.validation.CommonConst');

class TemplateWorkDayConst {

    const NAME_MIN_LENGTH = CommonConst::ENTITY_NAME_MIN_LENGTH;
    const NAME_MAX_LENGTH = CommonConst::ENTITY_NAME_MAX_LENGTH;
    const NAME_PATTERN = CommonConst::ENTITY_NAME_PATTERN;  
    
    
    const NAME_REQUIERED_MSG = CommonConst::ENTITY_NAME_REQUIERED_MESSAGE;
    const NAME_IS_NOT_UNIQUE_MSG = 'Шаблон с таким именем уже существует.';
    const NAME_TOO_SHORT_MSG = CommonConst::ENTITY_NAME_TOO_SHORT_MSG;
    const NAME_TOO_LONG_MSG = CommonConst::ENTITY_NAME_TOO_LONG_MSG;
    const NAME_IS_NOT_CORRECT_MSG = CommonConst::ENTITY_NAME_IS_NOT_CORRECT_MSG;        
    
    private function __construct() {
       
    }
    
}