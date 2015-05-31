<?php

Yii::import('application.constant.Operations');

class CheckAccessBehavior extends CBehavior {
   
    public function getIsUserCanViewUsers() {
        return $this->determineOperationAccess(Operations::VIEW_USERS);
    }
    
    public function getIsUserCanModifyUsers() {
        return $this->determineOperationAccess(Operations::MANAGE_USERS);
    }
    
    public function getIsUserCanViewGroups() {
        return $this->determineOperationAccess(Operations::VIEW_GROUPS);
    }
    
    public function getIsUserCanModifyGroups() {
        return $this->determineOperationAccess(Operations::MANAGE_GROUPS);
    }
    
    public function getIsUserCanViewSpecializations() {
       return $this->determineOperationAccess(Operations::VIEW_SPECIALIZATIONS);
    }
    
    public function getIsUserCanModifySpecializations() {
        return $this->determineOperationAccess(Operations::MANAGE_SPECIALIZATIONS);
    }
    
    public function getIsUserCanViewDoctors() {
        return $this->determineOperationAccess(Operations::VIEW_DOCTORS);
    }
    
    public function getIsUserCanModifyDoctors() {
        return $this->determineOperationAccess(Operations::MANAGE_DOCTORS);
    }
    
    public function getIsUserCanViewSchedule() {
        return $this->determineOperationAccess(Operations::VIEW_SCHEDULE);
    }
    
    public function getIsUserCanModifySchedule() {
        return $this->determineOperationAccess(Operations::MANAGE_SCHEDULE);
    }
    
    public function getIsUserCanViewTemplateWorkDays() {
        return $this->determineOperationAccess(Operations::VIEW_TEMPLATE_WORK_DAYS);
    }
    
    public function getIsUserCanModifyTemplateWorkDays() {
        return $this->determineOperationAccess(Operations::MANAGE_TEMPLATE_WORK_DAYS);
    }
    
    public function getIsUserCanViewOrders() {
       return $this->determineOperationAccess(Operations::VIEW_ORDERS);
    }
    
    public function getIsUserCanModifyOrders() {
        return $this->determineOperationAccess(Operations::MANAGE_ORDERS);
    }
    
    public function getIsUserCanManageApplication() {
        return $this->determineOperationAccess(Operations::MANAGE_APPLICATION);
    }
    
    
    private function determineOperationAccess($operation) { 
        //return true;
        //TODO# В рабочей версии закомментировать 'return true' выше и 
        // расскомментировать код ниже.
        if (Yii::app()->user->checkAccess($operation) ) {
            return true;
        } else {
            return false;
        }  
    }
    
}
