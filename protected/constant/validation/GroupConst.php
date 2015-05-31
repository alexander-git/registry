<?php

Yii::import('application.constant.validation.CommonConst');

class GroupConst {

    const NAME_MIN_LENGTH = CommonConst::ENTITY_NAME_MIN_LENGTH;
    const NAME_MAX_LENGTH = CommonConst::ENTITY_NAME_MAX_LENGTH;
    const NAME_PATTERN = CommonConst::ENTITY_NAME_PATTERN;  

    const NAME_REQUIERED_MSG = CommonConst::ENTITY_NAME_REQUIERED_MESSAGE;
    const NAME_IS_NOT_UNIQUE_MSG = "Группа с таким именем уже существует.";
    const NAME_TOO_SHORT_MSG = CommonConst::ENTITY_NAME_TOO_SHORT_MSG;
    const NAME_TOO_LONG_MSG = CommonConst::ENTITY_NAME_TOO_LONG_MSG;
    const NAME_IS_NOT_CORRECT_MSG = CommonConst::ENTITY_NAME_IS_NOT_CORRECT_MSG;           
    
    const ENABLED_REQUIERED_MSG = "Состояние(включёна/выключена) группы должно быть заданным.";
    const ENABLED_IS_NOT_CORRECT_MSG = "Состояние(включёна/выключена) группы заданно не верно.";

    private function __construct() {
       
    }
    
}