<?php

Yii::import('constant.validation.CommonConst');

class WorkTimeConst {

    const TIME_PATTERN = CommonConst::TIME_DB_PATTERN;
    
    const TIME_REQUIERED_MSG = "Поле \"время\" должно быть заролненно.";
    const TIME_IS_NOT_CORRECT_MSG = CommonConst::TIME_DB_IS_NOT_CORRECT_MSG;
    
    const STATE_REQUIRED_MSG = "Поле \"состояние\" должно быть заролненно.";
    const STATE_IS_NOT_CORRECT_MSG = "Поле \"состояние\" заролненно не верно.";
    
    const ID_WORK_DAY_REQUIERED_MSG = 'День должен быть указан.';
    const ID_WORK_DAY_IS_NOT_EXIST_MSG = 'Такой день в рассписании не существует.';
    const ID_WORK_DAY_IS_NOT_CORRECT_MSG = 'IdWorkDay должно быть положительным целым числом.';
    
    private function __construct() {
       
    }
} 