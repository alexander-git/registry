<?php

Yii::import('system.utils.CFormatter');
Yii::import('constant.view.SpecializationViewConst');

class SpecializationInfoFormatter extends CFormatter {
    
    
    public function formatEnabled($enabled) {
        return SpecializationViewConst::getEnabledTextView($enabled);
    }    
    
    public function formatNeedDoctor($needDoctor) {
        return SpecializationViewConst::getNeedDoctorYesNoView($needDoctor);
    }  
    
    public function formatRecordOnTime($recordOnTime) {
        return SpecializationViewConst::getRecordOnTimeYesNoView($recordOnTime);
    } 
    
    public function formatProvisionalRecord($provisionalRecord) {
        return SpecializationViewConst::getProvisionalRecordYesNoView($provisionalRecord);   
    }
    
    public function formatGroupName($groupName) {
        return SpecializationViewConst::getGroupNameTextView($groupName);
    }
   
}