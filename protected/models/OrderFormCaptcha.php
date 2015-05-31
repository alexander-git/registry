<?php

Yii::import('constant.validation.OrderFormCaptchaConst');

// Создание модели формы(наслежование от CFormModel) применяется только для того, чтобы
// организовать взаимодейстиве CCaptchaValidatior c CCaptchaAction.
// В форме заказа есть и другие поля, но они присваиваются сразу модели Order и валидация 
// делается с её помощью.
class OrderFormCaptcha extends CFormModel {
    
    public $captchaCode = null;
    
    public function rules() 
    {
        return array(
            array(
                'captchaCode', 
                'captcha', 
                'allowEmpty' => false,
                'captchaAction' => 'visitor/record/captcha', 
                'message' => OrderFormCaptchaConst::CAPTCHA_CODE_IS_NOT_CORRECT_MSG
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'captchaCode' => 'Введите код с картинки'
        );
    }

}
