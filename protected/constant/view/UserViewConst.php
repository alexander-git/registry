<?php

Yii::import('application.model.User');
Yii::import('application.helpers.OutHelper');

class UserViewConst {
    
    const ROLE_OPERATOR_TEXT = 'Оператор';
    const ROLE_EDITOR_TEXT = 'Редактор';
    const ROLE_ADMIN_TEXT = 'Администратор';
    const ENABLED_TRUE_TEXT = 'Включён';
    const ENABLED_FALSE_TEXT = 'Отключён';
    
    const UNKNOWN_ROLE_EXCEPTION_MESSAGE = 'Неизвестная роль.'; 
    
    
    public static function getRoleSelectListArray() {
        return array (
            User::ROLE_OPERATOR => self::ROLE_OPERATOR_TEXT,
            User::ROLE_EDITOR => self::ROLE_EDITOR_TEXT,
            User::ROLE_ADMIN => self::ROLE_ADMIN_TEXT,
        );
    }
    
    public static function getRoleTextView($role) {
        $roles = self::getRoleSelectListArray();
        if (!isset($roles[$role]) ) {
            throw new Exception(self::UNKNOWN_ROLE_EXCEPTION_MESSAGE);
        }
        
        return $roles[$role];
    }
    
    public static function getEnabledTextView($enabled) {
        if ($enabled) {
            return self::ENABLED_TRUE_TEXT;
        } else {
            return self::ENABLED_FALSE_TEXT;
        }
    }
    
    public static function getFullName($firstname, $surname, $patronymic) {
        return OutHelper::insertSpacesBetweenValues($surname, $firstname, $patronymic);
    }
    
    private function __construct() {
    
    }
   
}
