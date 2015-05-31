<?php

Yii::import('system.utils.CFormatter');
Yii::import('constant.view.OrderViewConst');
Yii::import('constant.view.SpecializationViewConst');
Yii::import('constant.view.DoctorViewConst');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.DateTimeFormatHelper');

class OrderInfoFormatter extends CFormatter {
    
    public function formatDate($date) {
        return DateFormatHelper::dateDBViewToDateCommonTextView($date);  
    }
    
    public function formatTime($time) {
        return TimeFormatHelper::timeDBViewToTimeShortTextView($time);
    }  
    
    public function formatSpecialization($specialization) {
        return SpecializationViewConst::getSpecializationHrefHtmlView($specialization);
    }
    
    public function formatDoctor($doctor) {
        if ($doctor === null) {
            return OrderViewConst::ID_DOCTOR_TEXT_VIEW_WHEN_DOCTOR_IS_NOT_SET;
        } else {
            return DoctorViewConst::getDoctorHrefHtmlView($doctor);
        }
    }
    
    
    public function formatOrderDateTime($orderDateTime) {
        return DateTimeFormatHelper::dateTimeDBViewToDateTimeCommonTextView($orderDateTime);
    }
   
    public function formatProcessed($processed) {
        return OrderViewConst::getProcessedYesNoView($processed);
    }    
    
    public function formatState($state) {
        return OrderViewConst::getStateTextView($state);
    }
  
}