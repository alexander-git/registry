<?php

Yii::import('application.helpers.OutHelper');

class OrderViewConst {
    
    const PROCESSED_TRUE_TEXT = 'Обработана';
    const PROCESSED_FALSE_TEXT = 'Необработана';
    
    const PROCESSED_YES_TEXT = 'Да';
    const PROCESSED_NO_TEXT = 'Нет';
    
    const STATE_NOT_DEFINED_TEXT = 'Не определено';
    const STATE_RESOLVED_TEXT = 'Принята';
    const STATE_REJECTED_TEXT = 'Отклонена';
    
    const ID_DOCTOR_TEXT_VIEW_WHEN_DOCTOR_IS_NOT_SET = 'Не задан';
    
    private static $stateToText = array(
        Order::STATE_NOT_DEFINED => self::STATE_NOT_DEFINED_TEXT,
        Order::STATE_RESOLVED => self::STATE_RESOLVED_TEXT,
        Order::STATE_REJECTED => self::STATE_REJECTED_TEXT
    );
    
    public static function getStateArrayForSelectTag() {
        return self::$stateToText;
    }
    
    public static function getProcessedTextView($processed) {
        if ($processed) {
            return self::PROCESSED_TRUE_TEXT;
        } else {
            return self::PROCESSED_FALSE_TEXT ;
        }
    }
    
    public static function getProcessedYesNoView($processed) {
        if ($processed) {
            return self::PROCESSED_YES_TEXT;
        } else {
            return self::PROCESSED_NO_TEXT;
        }
    }
    
    public static function getStateTextView($state) {
        return self::$stateToText[$state];
    }
    
    public static function getNameTextView($firstname, $surname, $patronymic) {
        $text = OutHelper::insertSpacesBetweenValues($surname, $firstname, $patronymic);
        return $text;
    }
    
    
    private function __construct() {
    
    }
    
}
