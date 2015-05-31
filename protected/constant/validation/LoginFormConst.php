<?php

Yii::import('constant.validation.UserConst');

class LoginFormConst {
    
    const NAME_MIN_LENGTH = UserConst::NAME_MIN_LENGTH;
    const NAME_MAX_LENGTH = UserConst::NAME_MAX_LENGTH;
    
    const NAME_REQUIERED_MSG = 'Имя не должно быть пустым.';
    const NAME_TOO_SHORT_MSG = 'Имя слишком корроткое.';
    const NAME_TOO_LONG_MSG = 'Имя слишком длинное.';
    
    const PASSWORD_REQUIERED_MSG = UserConst::PASSWORD_REQUIERED_MSG ;
        
    const NOT_CORRECT_USERNAME_OR_PASSWORD_MSG = "Неверное имя пользователя или пароль."; 
    const CAPTCHA_CODE_IS_NOT_CORRECT_MSG = 'Код с картинки введён неправильно.';
    
    const MAX_INVALID_INPUTS_BEFORE_SHOW_CAPTCHA = 3;
    
    private function __construct() {
        
    }
    
}
