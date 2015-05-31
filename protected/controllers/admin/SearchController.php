<?php

Yii::import('constant.Values');
Yii::import('constant.Operations');
Yii::import('utils.ResponseWriter');
Yii::import('helpers.OutHelper');
Yii::import('constant.view.SpecializationViewConst');
Yii::import('constant.view.DoctorViewConst');
Yii::import('managers.group.GroupManager');
Yii::import('managers.specialization.SpecializationManager');
Yii::import('managers.doctor.DoctorManager');
Yii::import('managers.templateWorkDay.TemplateWorkDayManager');
Yii::import('managers.SearchCriteria');

class SearchController extends AdminController
{
    const GROUP_SCHEDULE_ADDRESS = '/admin/schedule/group';
    const GROUP_SCHEDULE_GET_VAR_NAME = 'idGroup';
    
    const SPECIALIZATION_SCHEDULE_ADDRESS = '/admin/schedule/specialization';
    const SPECIALIZATION_SCHEDULE_GET_VAR_NAME = 'idSpecialization';
    
    const DOCTOR_SCHEDULE_ADDRESS = '/admin/schedule/doctor';
    const DOCTOR_SCHEDULE_GET_VAR_NAME = 'idDoctor';
    
    
    public function filters()
    {
        return array(
            'accessControl', 
            'ajaxOnly + groupSchedules',
            'ajaxOnly + specializationSchedules',
            'ajaxOnly + doctorSchedules',
            'ajaxOnly + groupSelect',
            'ajaxOnly + specializationSelect',
            'ajaxOnly + doctorSelect',
            'ajaxOnly + templateWorkDaySelect'
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('groupSchedules', 'groupSelect'),
                'roles' => array(Operations::VIEW_GROUPS), 
            ),
            array(
                'allow',
                'actions' => array('specializationSchedules', 'specializationSelect'),
                'roles' => array(Operations::VIEW_SPECIALIZATION), 
            ),
            array(
                'allow',
                'actions' => array('doctorSchedules', 'doctorSelect'),
                'roles' => array(Operations::VIEW_DOCTOR), 
            ),
            array (
                'allow',
                'actions' => array('templateWorkDaySelect'),
                'roles' => array(Operations::VIEW_TEMPLATE_WORK_DAYS),
            ),
            array('deny', 'users' => array('*') ),
        );
    }
    
    public function actionGroupSchedules($search) {
        $searchResult = $this->groupSearchResultToTextIdArray($this->searchGroup($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText();
            return;
        } 
        
        $links = $this->textIdArrayToLinkArray($searchResult, self::GROUP_SCHEDULE_ADDRESS, self::GROUP_SCHEDULE_GET_VAR_NAME);
        echo OutHelper::insertBrBetweenValues($links);
    }
    
    public function actionSpecializationSchedules($search) {
        $searchResult = $this->specializationSearchResultToTextIdArray($this->searchSpecialization($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText();
            return;
        } 
        
        $links = $this->textIdArrayToLinkArray($searchResult, self::SPECIALIZATION_SCHEDULE_ADDRESS, self::SPECIALIZATION_SCHEDULE_GET_VAR_NAME);
        echo OutHelper::insertBrBetweenValues($links);
    }
    
    public function actionDoctorSchedules($search) {
       $searchResult = $this->doctorSearchResultToTextIdArray($this->searchDoctor($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText();
            return;
        } 
        
        $links = $this->textIdArrayToLinkArray($searchResult, self::DOCTOR_SCHEDULE_ADDRESS, self::DOCTOR_SCHEDULE_GET_VAR_NAME);
        echo OutHelper::insertBrBetweenValues($links);
    }
    
    public function actionGroupSelect($search) {   
        $searchResult = $this->groupSearchResultToSelectOptions($this->searchGroup($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText(); 
            return;
        }       
        $htmlOptions = array();
        echo CHtml::listOptions('', $searchResult, $htmlOptions);
    }
    
    public function actionSpecializationSelect($search) {   
        $searchResult = $this->specializationSearchResultToSelectOptions($this->searchSpecialization($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText(); 
            return;
        } 
        $htmlOptions = array();  
        echo CHtml::listOptions('', $searchResult, $htmlOptions);
    }
    
    public function actionDoctorSelect($search) {   
        $searchResult = $this->doctorSearchResultToSelectOptions($this->searchDoctor($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText(); 
            return;
        } 
        $htmlOptions = array();  
        echo CHtml::listOptions('', $searchResult, $htmlOptions);
    }
    
    public function actionTemplateWorkDaySelect($search) {
        $searchResult = $this->templateWorkDaySearchResultToSelectOptions($this->searchTemplateWorkDay($search) );
        if (count($searchResult) === 0) {
            $rw = new ResponseWriter();
            $rw->writeNotingIsFoundText(); 
            return;
        } 
        $htmlOptions = array();  
        echo CHtml::listOptions('', $searchResult, $htmlOptions);
    }
    
    private function searchGroup($search) {
        $searchCriteria = $this->preapareSearchCriteria($search);
        $groupManager = new GroupManager();
        $rows = $groupManager->searchGroup($searchCriteria);
        return $rows;
    }
   
    private function searchSpecialization($search) {
        $searchCriteria = $this->preapareSearchCriteria($search);
        $specializationManager = new SpecializationManager();
        $rows = $specializationManager->searchSpecialization($searchCriteria);
        return $rows;
    }
     
    private function searchDoctor($search) {
        $searchCriteria = $this->preapareSearchCriteria($search);
        $doctorManager = new DoctorManager();
        $rows = $doctorManager->searchDoctor($searchCriteria);
        return $rows;
    }
    
    private function searchTemplateWorkDay($search) {
        $searchCriteria = $this->preapareSearchCriteria($search);
        $templateWorkDayManager = new TemplateWorkDayManager();
        $rows = $templateWorkDayManager->searchTemplateWorkDay($searchCriteria);
        return $rows;
    }
       
    private function groupSearchResultToTextIdArray($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[] = array('id' => $r->id, 'text' => $r->name);
        }
        return $result;
    }
    
    private function specializationSearchResultToTextIdArray($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[] = array(
                'id' => $r->id, 
                'text' => SpecializationViewConst::getSpecializationTextView($r->name, $r->additional)
            );
        }
        return $result;
    }
    
    private function doctorSearchResultToTextIdArray($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[] = array(
                'id' => $r->id, 
                'text' => DoctorViewConst::getDoctorTextView($r->firstname, $r->surname, $r->patronymic, $r->additional)
            );
        }
        return $result;
    }
    
    private function groupSearchResultToSelectOptions($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[$r->id] = $r->name;
        }
        return $result;
    }
    
    private function specializationSearchResultToSelectOptions($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[$r->id] = SpecializationViewConst::getSpecializationTextView($r->name, $r->additional);
        }
        return $result;
    }
    
    private function doctorSearchResultToSelectOptions($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[$r->id] = DoctorViewConst::getDoctorTextView($r->firstname, $r->surname, $r->patronymic, $r->additional);
        }
        return $result;
    }
    
    private function templateWorkDaySearchResultToSelectOptions($rows) {
        $result = array();
        foreach ($rows as $r) {
            $result[$r->id] = $r->name;
        }
        return $result;
    }
    
    private function preapareSearchCriteria($search) {
        $searchCriteria = new SearchCriteria();
        if ($search !== '') {
            $searchCriteria->setText($search);
            $searchCriteria->setLimit(Values::MAX_RESULTS_IN_SEARCH);
        } else {
            $searchCriteria->notUseText();
            $searchCriteria->notUseLimit();
        }    
        return $searchCriteria;
    }
    
    private function textIdArrayToLinkArray($textIdArray, $address, $getVarName) {
        $result = array();
        foreach ($textIdArray as $e) {
            $result []= CHtml::link($e['text'], array($address, $getVarName => $e['id']) );
        }   
        return $result;
    }

}