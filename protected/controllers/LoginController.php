<?php

Yii::import('ext.actions.AdvancedCaptchaAction');
Yii::import('utils.LoginFormInfo');

class LoginController extends AdminController
{
    public $layout = '//layouts/admin';
    
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'AdvancedCaptchaAction',
                'foreColor' => 0x006A86,
                'testLimit' => 1,
            ),
        );
    }
    
    public function actionLogin() 
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->user->returnUrl);
        }
        
        $model = new LoginForm();
        $loginFormInfo = LoginFormInfo::getInstance();
        
        if (Yii::app()->request->getPost('LoginForm') ) {
            $model->attributes = Yii::app()->request->getPost('LoginForm');
            
            if($model->validate() && $model->login() ) {
                // Если пользователь будучи незалогиненым пытался получить
                // доступ к странице для которой нужно авторизоваться, то он
                // будет переброшен на страницу логина и в случее успешной 
                // авторизации тот адрес на который он хотел зайти изначально 
                // будут в returnUrl. Если же пользователь просто открыл форму
                // логина и вошёл, то в качестве returnUrl буде использоваться 
                // defualtUrl. Если он был бы не задан, то переход 
                // осуществлялся бы на адрес '/' - где, в зависимости от 
                // настроек приложения, пользователь был бы перенаправлен к
                // нужной странице.
                // $defaultUrl - стартовая страница администраторской  
                // части сайта.
                $defaultUrl = $this->createUrl('admin/general/main');
                
                $this->redirect(Yii::app()->user->getReturnUrl($defaultUrl) );
                
                $loginFormInfo->validInputOccured();
            } else {
                $loginFormInfo->invalidInputOccured();
            }
            // В любом случае очистить пароль и капучу.
            $model->password = '';
            $model->captchaCode = '';
        }
        $this->render(
            'login', 
            array(
                'model' => $model,
                'isNeedShowCaptcha' => $loginFormInfo->isNeedShowCaptcha()
            ) 
        );
    }    

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
  
}