<?php

$groupsUrl = $this->createUrl('visitor/record/groups');
$specializationsUrl = $this->createUrl('visitor/record/specializations');
$doctorsUrl = $this->createUrl('visitor/record/doctors');
$scheduleUrl = $this->createUrl('visitor/record/schedule');
$dayUrl = $this->createUrl('visitor/record/day');
$navigationDataUrl = $this->createUrl('visitor/record/navigationData');
$makeOrderUrl = $this->createUrl('visitor/record/makeOrder');

$captchaUrl = $this->createUrl('visitor/record/captcha');

$captchaRefreshGetVarName = CCaptchaAction::REFRESH_GET_VAR;

Yii::app()->clientScript->registerScript(
   'recordAppUrls',
    "
      
    var recordAppUrls = {
        'groupsUrl' : '$groupsUrl',
        'specializationsUrl' : '$specializationsUrl',
        'doctorsUrl' : '$doctorsUrl',
        'scheduleUrl' : '$scheduleUrl',
        'dayUrl' : '$dayUrl',        
        'navigationDataUrl' : '$navigationDataUrl',
        'makeOrderUrl' : '$makeOrderUrl',
        'captchaUrl' : '$captchaUrl',
    };
    
    var recordAppConst = {
        'CAPTCHA_REFRESH_GET_VAR_NAME' : '$captchaRefreshGetVarName' 
    };

    ",
   CClientScript::POS_HEAD
); 