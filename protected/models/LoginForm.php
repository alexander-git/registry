<?php

Yii::import('constant.validation.LoginFormConst');
Yii::import('utils.LoginFormInfo');

class LoginForm extends CFormModel
{
    public $name;
    public $password;
    
    public $captchaCode = null;

    private $identity;

    public function rules()
    {
        return array(
            array('name', 'required', 'message' => LoginFormConst::NAME_REQUIERED_MSG),
            array(
                'name', 
                'length',  
                'max' => LoginFormConst::NAME_MAX_LENGTH, 
                'tooLong' => LoginFormConst::NAME_TOO_LONG_MSG
            ), 
            array('password', 'required', 'message' => LoginFormConst::PASSWORD_REQUIERED_MSG),
            array('password', 'authenticate'),
            
            array(
                'captchaCode', 
                'captcha', 
                'allowEmpty' => $this->allowEmptyCaptcha(),
                'captchaAction' => 'login/captcha', 
                'message' => LoginFormConst::CAPTCHA_CODE_IS_NOT_CORRECT_MSG
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Имя',
            'password' => 'Пароль'
        );
    }

    public function authenticate($attribute, $params)
    {
        if(!$this->hasErrors() )  {
            $this->identity = new UserIdentity($this->name, $this->password);
            if(!$this->identity->authenticate() ) {
                $this->addError('password', LoginFormConst::NOT_CORRECT_USERNAME_OR_PASSWORD_MSG);
            }
        }
    }

    public function allowEmptyCaptcha() {
        return !LoginFormInfo::getInstance()->isNeedShowCaptcha();
    }

    public function login()
    {
        if($this->identity === null) {
            $this->identity = new UserIdentity($this->name, $this->password);
            $this->identity->authenticate();
        }
        
        if($this->identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($this->identity);
            return true;
        } else {
           return false;
        }
    }

}
