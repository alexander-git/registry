<?php

class ModelHelper {

    // Возвращает первыую  ошибку для модели.
    // Модель должн быть провалидирована.
    public static function getFirstError($model) {
        $firstError = null;
        foreach($model->getErrors() as $attribute) {
            $firstError = $attribute[0];
            break;
        }
        return $firstError;
    }
    
    // Возвращает первые ошибки(если они есть) для каждого атрибута модели.
    // Модель должна быть провалидирована.
    public static function getFirstErrors($model) {
        $firstErrors = array();
        foreach($model->getErrors() as $attribute) {
            $firstErrors []= $attribute[0];
        }
        return $firstErrors;
    }
    
    private function __construct() {
         
    }
    
}