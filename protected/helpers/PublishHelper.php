<?php

class PublishHelper {
    
    public static function publishAndRegisterCssFile($pathToFile) {
         $url = Yii::app()->assetManager->publish($pathToFile);
         Yii::app()->clientScript->registerCssFile($url); 
    }

    public static function publishAndRegisterScriptFile($pathToFile) {
         $url = Yii::app()->assetManager->publish($pathToFile);
         Yii::app()->clientScript->registerScriptFile($url); 
    }
    
    private function __construct() { 
    
    }
    
}