<?php

Yii::import('application.constant.validation.CommonConst');

class TemplateWorkTimeConst {
     const TIME_PATTERN = CommonConst::TIME_DB_PATTERN;
    
    const TIME_REQUIERED_MSG = "Поле \"время\" должно быть заролненно.";
    const TIME_IS_NOT_CORRECT_MSG = CommonConst::TIME_DB_IS_NOT_CORRECT_MSG;
    
    const STATE_REQUIRED_MSG = "Поле \"состояние\" должно быть заролненно.";
    const STATE_IS_NOT_CORRECT_MSG = "Поле \"состояние\" заролненно не верно.";
    
    const ID_TEMPLATE_WORK_DAY_REQUIERED_MSG = 'Шаблон должен быть указан.';
    const ID_TEMPLATE_WORK_DAY_IS_NOT_EXIST_MSG = 'Такой шаблона не существует.';
    const ID_TEMPLATE_WORK_DAY_IS_NOT_CORRECT_MSG = 'IdTemplateWorkDay должно быть положительным целым числом.';

    private function __construct() {
       
    }
} 