<?php

Yii::import('application.helpers.OutHelper');

class SpecializationViewConst {
    
    const ENABLED_TRUE_TEXT = 'Включёна';
    const ENABLED_FALSE_TEXT = 'Отключена';
    const NEED_DOCTOR_TRUE_TEXT = 'Использовать запись с указанием врача';
    const NEED_DOCTOR_FALSE_TEXT = 'Использовать запись без указания врача';
    const RECORD_ON_TIME_TRUE_TEXT = 'Возможна запись на определённое время';
    const RECORD_ON_TIME_FALSE_TEXT = 'Запись на определённое время невозможна';
    const PROVISIONAL_RECORD_TRUE_TEXT = 'Возможна предварительная запись';
    const PROVISIONAL_RECORD_FALSE_TEXT = 'Предварительная запись невозможна';
    const GROUP_IS_EMPTY_TEXT_VIEW = 'Не задана';
    
    const RECORD_YES_TEXT = 'Возможна';
    const RECORD_NO_TEXT = 'Невозможна';
    
    const NEED_DOCTOR_YES_TEXT = 'Да';
    const NEED_DOCTOR_NO_TEXT = 'Нет';
    
    
    
    public static function getEnabledTextView($enabled) {
        if ($enabled) {
            return self::ENABLED_TRUE_TEXT;
        } else {
            return self::ENABLED_FALSE_TEXT;
        }
    }
    
    public static function getNeedDoctorTextView($needDoctor) {
        if ($needDoctor) {
            return self::NEED_DOCTOR_TRUE_TEXT;
        } else {
            return self::NEED_DOCTOR_FALSE_TEXT;
        }
    }
    
    public static function getRecordOnTimeTextView($recordOnTime) {
        if ($recordOnTime) {
            return self::RECORD_ON_TIME_TRUE_TEXT;
        } else {
            return self::RECORD_ON_TIME_FALSE_TEXT;
        }
    }
    
    public static function getProvisionalRecordTextView($provisionalRecord) {
        if ($provisionalRecord) {
            return self::PROVISIONAL_RECORD_TRUE_TEXT;
        } else {
            return self::PROVISIONAL_RECORD_FALSE_TEXT;
        }
    }
    
    public static function getGroupNameTextView($groupName) {        
        if (($groupName === '') || ($groupName === null) ) {
            return self::GROUP_IS_EMPTY_TEXT_VIEW;
        } else {
            return $groupName;
        }
    }
    
    public static function getNeedDoctorYesNoView($needDoctor) {
         if ($needDoctor) {
            return self::NEED_DOCTOR_YES_TEXT;
        } else {
            return self::NEED_DOCTOR_NO_TEXT;
        }  
    }
    
    public static function getRecordOnTimeYesNoView($recordOnTime) {
        if ($recordOnTime) {
            return self::RECORD_YES_TEXT;
        } else {
            return self::RECORD_NO_TEXT;
        }
    }
    
    public static function getProvisionalRecordYesNoView($provisionalRecord) {
        if ($provisionalRecord) {
            return self::RECORD_YES_TEXT;
        } else {
            return self::RECORD_NO_TEXT;
        }
    }
    
    public static function getSpecializationTextView($name, $additional) {
        $text = $name;
        // Если additional не пустое, то заключаем его в скобки
        if (!OutHelper::isEmpty($additional) ) {
            $text .= OutHelper::surroundWithBrackets($additional);
        }
        
        return $text;
    }
    
    public static function getSpecializationHrefHtmlView($specialization) {
        $text = self::getSpecializationTextView($specialization->name, $specialization->additional);
        return CHtml::link($text, array('admin/specialization/view', 'id' => $specialization->id) );
    }
    
    private function __construct() {
    
    }
    
}
