<?php

Yii::import('application.constant.Responses');

class ResponseWriter {

    public function __construct() {
    
    }
    
    public function writeNotingIsFoundText() {
        echo Responses::AJAX_SEARCH_NOTHING_IS_FOUND_MESSAGE;   
    }
    
    public function writeSuccessJson($successValue = true) {
        echo json_encode(array(Responses::JSON_SUCCESS_PROPERTY => $successValue) );  
    }
    
    public function writeErrorJson($errorValue = true) {
        echo json_encode(array(Responses::JSON_ERROR_PROPERTY => $errorValue) );  
    }
    
}