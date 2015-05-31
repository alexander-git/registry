<?php

Yii::import('system.utils.CFormatter');
Yii::import('constant.view.GroupViewConst');

class GroupInfoFormatter extends CFormatter {
    
    public function formatEnabled($enabled) {
        return GroupViewConst::getEnabledTextView($enabled);
    }    
    
}