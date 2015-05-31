<?php

Yii::import('helpers.JsonHelper');

class JsonEncoder {
   
    public function __construct() {
            
    }
    
    public function prepareGroupToJsonEncode($group) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($group->id),
            'name' => $group->name,
            'enabled' => JsonHelper::prepareBooleanToEncode($group->enabled),
        );   
        
        return $result;
    }

    public function prepareGroupsToJsonEncode($groups) {
        $result = array();
        foreach ($groups as $g) {
            $result[] = $this->prepareGroupToJsonEncode($g);
        }
        return $result;
    }
    
    public function prepareSpecializationToJsonEncode($specialization) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($specialization->id),
            'name' => $specialization->name,
            'additional' => $specialization->additional,
            'enabled' => JsonHelper::prepareBooleanToEncode($specialization->enabled),
            'needDoctor' => JsonHelper::prepareBooleanToEncode($specialization->needDoctor),
            'recordOnTime' => JsonHelper::prepareBooleanToEncode($specialization->recordOnTime),
            'provisionalRecord' => JsonHelper::prepareBooleanToEncode($specialization->provisionalRecord),
            'idGroup' => JsonHelper::prepareIntegerOrNullToEncode($specialization->idGroup)
        );   
        
        return $result;
    }
    
    public function prepareSpecializationsToJsonEncode($specializations) {
        $result = array();
        foreach ($specializations as $s) {
            $result[] = $this->prepareSpecializationToJsonEncode($s);
        }
        return $result;
    }
    
    public function prepareDoctorWithoutInfoToJsonEncode($doctor) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($doctor->id),
            'firstname' => $doctor->firstname,
            'surname' => $doctor->surname,
            'patronymic' => $doctor->patronymic,
            'additional' => $doctor->additional,
            'enabled' => JsonHelper::prepareBooleanToEncode($doctor->enabled),
            'speciality' => $doctor->speciality
        );   
        
        return $result;
    }
    
    public function prepareDoctorsWithoutInfoToJsonEncode($doctors) {
        $result = array();
        foreach ($doctors as $d) {
            $result[] = $this->prepareDoctorWithoutInfoToJsonEncode($d);
        }
        return $result;
    }
    
    public function prepareWorkDayToJsonEncode($workDay) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($workDay->id),
            'date' => DateFormatHelper::dateDBViewToDateCommonTextView($workDay->date),
            'idSpecialization' => JsonHelper::prepareIntegerToEncode($workDay->idSpecialization),
            'idDoctor' => JsonHelper::prepareIntegerOrNullToEncode($workDay->idDoctor),
            'published' => JsonHelper::prepareBooleanToEncode($workDay->published),
        );   
        
        return $result;
    }
       
    public function prepareWorkTimeToJsonEncocode($workTime) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($workTime->id),
            'timeTextView' => TimeFormatHelper::timeDBViewToTimeShortTextView($workTime->time),
            'state' => $workTime->state,
            'idWorkDay' => JsonHelper::prepareIntegerToEncode($workTime->idWorkDay),
        );   
        
        return $result;
    }
    
    public function prepareWorkDayWithTimeToJsonEncode($workDay) {
        $result = $this->prepareWorkDayToJsonEncode($workDay);
        
        $time = array();
        foreach ($workDay->time as $wt) {
            $time[] = $this->prepareWorkTimeToJsonEncocode($wt);
        }
        $result['time'] = $time;
        
        return $result;
    }
 
    public function prepareWorkDaysToJsonEncode($workDays) {
        $result = array();
        foreach ($workDays as $wd) {
            $result[] = $this->prepareWorkDayToJsonEncode($wd);
        }
        return $result;
    }
    
    public function prepareTemplateWorkDayToJsonEncode($templateWorkDay) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($templateWorkDay->id),
            'name' => $templateWorkDay->name,
        );  
        return $result;   
    }
    
    public function prepareTemplateWorkTimeToJsonEncode($templateWorkTime) {
        $result = array(
            'id' => JsonHelper::prepareIntegerToEncode($templateWorkTime->id),
            'timeTextView' => TimeFormatHelper::timeDBViewToTimeShortTextView($templateWorkTime->time),
            'state' => $templateWorkTime->state,
            'idTemplateWorkDay' => JsonHelper::prepareIntegerToEncode($templateWorkTime->idTemplateWorkDay),
        );   
        
        return $result;
    }
    
    public function prepareTemplateWorkDayWithTimeToJsonEncode($templateWorkDay) {
        $result = $this->prepareTemplateWorkDayToJsonEncode($templateWorkDay);
        
        $time = array();
        foreach ($templateWorkDay->time as $twt) {
            $time[] = $this->prepareTemplateWorkTimeToJsonEncode($twt);
        }
        $result['time'] = $time;
        
        return $result; 
    }
    
     
}
