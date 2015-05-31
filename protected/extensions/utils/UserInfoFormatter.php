<?php

Yii::import('system.utils.CFormatter');
Yii::import('constant.view.UserViewConst');

class UserInfoFormatter extends CFormatter {
    
    public function formatRole($role) {
        return UserViewConst::getRoleTextView($role);
    }
    
    public function formatEnabled($enabled) {
        return UserViewConst::getEnabledTextView($enabled);
    }    
    
}