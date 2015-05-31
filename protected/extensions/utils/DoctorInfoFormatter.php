<?php

Yii::import('system.utils.CFormatter');
Yii::import('constant.view.DoctorViewConst');

class DoctorInfoFormatter extends CFormatter {
     
    public function formatEnabled($enabled) {
        return DoctorViewConst::getEnabledTextView($enabled);
    }    
   
    public function formatInfo($info) {
        return DoctorViewConst::getInfoTextView($info);
    }  
    
    public function formatSpecializations($specializations) {
        return DoctorViewConst::getSpecializationsHrefHtmlView($specializations);
    }
    
}