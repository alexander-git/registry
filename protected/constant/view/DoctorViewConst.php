<?php

Yii::import('constant.view.SpecializationViewConst');
Yii::import('helpers.OutHelper');

class DoctorViewConst {
    
    const ENABLED_TRUE_TEXT = 'Включён';
    const ENABLED_FALSE_TEXT = 'Отключен';
    const SPECIALIZTIONS_IS_NOT_SET = 'Специализации не заданны.';
    const SPECIALOZATIONS_HREF_HTML_VIEW_DELIMITER = "<br />\n";
    
    public static function getEnabledTextView($enabled) {
        if ($enabled) {
            return self::ENABLED_TRUE_TEXT;
        } else {
            return self::ENABLED_FALSE_TEXT;
        }
    }
    
    public static function getInfoTextView($info) {
        if ($info === null) {
            return '';
        } else {
            return $info;
        }
    }
    
    public static function getSpecializationsHrefHtmlView($specializations) {
        if ($specializations === null || $specializations === array() ) {
            return self::SPECIALIZTIONS_IS_NOT_SET;
        }
        $result = '';
        $count = count($specializations);
        for ($i = 0; $i < $count; $i++ ) {
            $id = $specializations[$i]->id;
            $name = $specializations[$i]->name;
            $additional = $specializations[$i]->additional;
            
            $text = SpecializationViewConst::getSpecializationTextView($name, $additional);
            
            $result .= CHtml::link($text, array('/admin/specialization/view', 'id' => $id) );
            if ($i !== ($count - 1) ) {
                $result .= self::SPECIALOZATIONS_HREF_HTML_VIEW_DELIMITER;
            }
        }
        return $result;
    }
    
    public static function getDoctorTextView($firstname, $surname, $patronymic, $additional) {
        $text = OutHelper::insertSpacesBetweenValues($surname, $firstname, $patronymic);
        // Если additional не пустое то украшаем его
        if (!OutHelper::isEmpty($additional) ) {
            $text .= OutHelper::surroundWithBrackets($additional);
        }

        return $text;
    }
    
    public static function getDoctorHrefHtmlView($doctor) {
        $text = self::getDoctorTextView(
            $doctor->firstname, 
            $doctor->surname, 
            $doctor->patronymic, 
            $doctor->additional
        );
        
        return CHtml::link($text, array('/admin/doctor/view', 'id' => $doctor->id) );
    }
    

    
    private function __construct() {
    
    }
    
}
