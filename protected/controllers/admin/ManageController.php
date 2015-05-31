<?php

Yii::import('constant.Operations');
Yii::import('constant.FlashMessages');
Yii::import('utils.ResponseWriter');
Yii::import('utils.ApplicationConfig');
Yii::import('helpers.FlashMessageHelper');

class ManageController extends AdminController
{
    const UPDATE_APPLICATION_CONFIG_FORM_ID = "updateApplicationConfigFormId";
    
    public $layout = '//layouts/admin';
    public $manageMenu = null;
    
    public function filters()
    {
        return array(
            'accessControl', 
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('config', 'adminActions'),
                'roles' => array(Operations::MANAGE_APPLICATION), 
            ),
            array(
                'allow',
                'actions' => array('installUserRoles'),
                // Пользователю с именем admin разрешено установить роли пользователей,
                // независимо от того какая у него роль. Это нужно при первичной установке приложения
                // когда пользователь с именем admin уже существует в БД,  но 
                // роль администратора  к нему ещё не привязана.
                'users' => array('admin'), 
            ),
            array(
                'allow',
                'actions' => array('installUserRoles'),
                'roles' => array(Operations::MANAGE_APPLICATION), 
            ),
            
            array('deny', 'users' => array('*') ),
        );
    }
    
    
    public function actionConfig()
    {
        $model = $this->getApplicationConfigFormModelAccordingCurrentConfigState();
        
        $this->performAjaxValidationFoApplicationrConfigFrom($model);
        
        if(isset($_POST['ApplicationConfigForm']) ) {
            $model->attributes = $_POST['ApplicationConfigForm'];
            if ($model->validate() ) {
                $applicationConfig = ApplicationConfig::getInstance();
                $applicationConfig->setOnModel($model);
                FlashMessageHelper::setSuccessMessage(FlashMessages::APPLICATION_CONFIG_UPDATE_SUCCESS);
            }
        }
        
        $this->render('config', array('model' => $model) );
    }
    
    public function actionAdminActions()
    {
        $this->render('adminActions');
    }
    
    public function actionInstallUserRoles() {
        $this->installUserRoles();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('installUserRolesComplete');
        } else {
            $rw = new ResponseWriter();
            $rw->writeSuccessJson();
        }
    }
    
    private function getApplicationConfigFormModelAccordingCurrentConfigState() {
       $applicationConfig = ApplicationConfig::getInstance();
       $form = new ApplicationConfigForm();
       $form->attributes = $applicationConfig->getAsArray();
       return $form ;       
    }
       
    private function installUserRoles() {
        $a = Yii::app()->authManager;

        // Удаляем все существующие правила
        $a->clearAll();

        // Опрерация выхода с сайта
        $a->createOperation(Operations::LOGOUT, 'Выход'); 
        
        // Операции c пользователями
        $a->createOperation(Operations::INDEX_USER, 'Список пользователей для изменения');
        $a->createOperation(Operations::VIEW_USER, 'Посмотреть информацию о пользователе');
        $a->createOperation(Operations::CREATE_USER, 'Создание пользователя');
        $a->createOperation(Operations::UPDATE_USER, 'Редектирование пользователя');
        $a->createOperation(Operations::DELETE_USER, 'Удаление пользователя');
        
        // Все операции для просмотра пользователей
        $viewUsersOperation = $a->createOperation(Operations::VIEW_USERS, 'Управление пользователями');
        $viewUsersOperation->addChild(Operations::INDEX_USER);
        $viewUsersOperation->addChild(Operations::VIEW_USER);
        
        // Все опрерации по управлению пользователями
        $manageUsersOperation = $a->createOperation(Operations::MANAGE_USERS, 'Управление пользователями');
        $manageUsersOperation->addChild(Operations::VIEW_USERS);
        $manageUsersOperation->addChild(Operations::CREATE_USER);
        $manageUsersOperation->addChild(Operations::UPDATE_USER);
        $manageUsersOperation->addChild(Operations::DELETE_USER);
                
        // Операции c группами
        $a->createOperation(Operations::INDEX_GROUP, 'Список групп');
        $a->createOperation(Operations::VIEW_GROUP, 'Посмотреть информацию о группе');
        $a->createOperation(Operations::CREATE_GROUP, 'Создание группы');
        $a->createOperation(Operations::UPDATE_GROUP, 'Обновить информацию о группе');
        $a->createOperation(Operations::DELETE_GROUP, 'Удалиь группу');
          
        
        // Все операции для просмотра групп
        $viewGroupsOperation = $a->createOperation(Operations::VIEW_GROUPS, 'Смотреть информацию о группах');
        $viewGroupsOperation->addChild(Operations::INDEX_GROUP);
        $viewGroupsOperation->addChild(Operations::VIEW_GROUP);
        
        // Все опрерации по управлению группами
        $manageGroupsOperation = $a->createOperation(Operations::MANAGE_GROUPS, 'Управление группами');
        $manageGroupsOperation->addChild(Operations::VIEW_GROUPS);
        $manageGroupsOperation->addChild(Operations::CREATE_GROUP);
        $manageGroupsOperation->addChild(Operations::UPDATE_GROUP);
        $manageGroupsOperation->addChild(Operations::DELETE_GROUP);
        
        
        // Операции c специализациями
        $a->createOperation(Operations::INDEX_SPECIALIZATION, 'Список специализаций');
        $a->createOperation(Operations::VIEW_SPECIALIZATION, 'Посмотреть информацию о специализации');
        $a->createOperation(Operations::CREATE_SPECIALIZATION, 'Создание специализации');
        $a->createOperation(Operations::UPDATE_SPECIALIZATION, 'Обновить информацию о специализации');
        $a->createOperation(Operations::DELETE_SPECIALIZATION, 'Удалиь специализацию');
        
         // Все операции для просмотра специализаций
        $viewSpecializationsOperation = $a->createOperation(Operations::VIEW_SPECIALIZATIONS, 'Смотреть информацию о специализациях');
        $viewSpecializationsOperation->addChild(Operations::INDEX_SPECIALIZATION);
        $viewSpecializationsOperation->addChild(Operations::VIEW_SPECIALIZATION);
        
        // Все опрерации по управлению специализациями
        $manageSpecializationsOperation = $a->createOperation(Operations::MANAGE_SPECIALIZATIONS, 'Управление специализациями');
        $manageSpecializationsOperation->addChild(Operations::VIEW_SPECIALIZATIONS);
        $manageSpecializationsOperation->addChild(Operations::CREATE_SPECIALIZATION);
        $manageSpecializationsOperation->addChild(Operations::UPDATE_SPECIALIZATION);
        $manageSpecializationsOperation->addChild(Operations::DELETE_SPECIALIZATION);
        
        // Операции c врачами
        $a->createOperation(Operations::INDEX_DOCTOR, 'Список врачей');
        $a->createOperation(Operations::VIEW_DOCTOR, 'Посмотреть информацию о враче');
        $a->createOperation(Operations::CREATE_DOCTOR, 'Создание врача');
        $a->createOperation(Operations::UPDATE_DOCTOR, 'Обновить информацию о враче');
        $a->createOperation(Operations::DELETE_DOCTOR, 'Удалиь врача');
        
         // Все операции для просмотра врачей
        $viewDoctorsOperation = $a->createOperation(Operations::VIEW_DOCTORS, 'Смотреть информацию о врачах');
        $viewDoctorsOperation->addChild(Operations::INDEX_DOCTOR);
        $viewDoctorsOperation->addChild(Operations::VIEW_DOCTOR);
        
        // Все опрерации по управлению врачами
        $manageDoctorsOperation = $a->createOperation(Operations::MANAGE_DOCTORS, 'Управление врачами');
        $manageDoctorsOperation->addChild(Operations::VIEW_DOCTORS);
        $manageDoctorsOperation->addChild(Operations::CREATE_DOCTOR);
        $manageDoctorsOperation->addChild(Operations::UPDATE_DOCTOR);
        $manageDoctorsOperation->addChild(Operations::DELETE_DOCTOR);
        
        // Операции c рассписанием
        $a->createOperation(Operations::VIEW_SCHEDULE, 'Просмотр рассписания');
        $manageScheduleOperation = $a->createOperation(Operations::MANAGE_SCHEDULE, 'Изменение рассписания');
        $manageScheduleOperation->addChild(Operations::VIEW_SCHEDULE);
        
         // Операции c шаблонами рабочего дня
        $a->createOperation(Operations::INDEX_TEMPLATE_WORK_DAY, 'Список шаблонов рабочего дня');
        $a->createOperation(Operations::VIEW_TEMPLATE_WORK_DAY, 'Посмотреть информацию о шаблоне рабочего дня');
        $a->createOperation(Operations::CREATE_TEMPLATE_WORK_DAY, 'Создание шаблона рабочего дня');
        $a->createOperation(Operations::UPDATE_TEMPLATE_WORK_DAY, 'Редектирование  шаблона рабочего дня');
        $a->createOperation(Operations::DELETE_TEMPLATE_WORK_DAY, 'Удаление  шаблона рабочего дня');
        
        // Все операции для просмотра шаблонов рабочего дня
        $viewTemplatesWorkDaysOperation = $a->createOperation(Operations::VIEW_TEMPLATE_WORK_DAYS, 'Смотреть информации о шаблонах рабочего дня');
        $viewTemplatesWorkDaysOperation->addChild(Operations::INDEX_TEMPLATE_WORK_DAY);
        $viewTemplatesWorkDaysOperation->addChild(Operations::VIEW_TEMPLATE_WORK_DAY);
        
        // Все опрерации по управлению рабочего дня 
        $manageTemplatesWorkDaysOperation = $a->createOperation(Operations::MANAGE_TEMPLATE_WORK_DAYS, 'Управление шаблонами рабочего дня');
        $manageTemplatesWorkDaysOperation->addChild(Operations::VIEW_TEMPLATE_WORK_DAYS);
        $manageTemplatesWorkDaysOperation->addChild(Operations::CREATE_TEMPLATE_WORK_DAY);
        $manageTemplatesWorkDaysOperation->addChild(Operations::UPDATE_TEMPLATE_WORK_DAY);
        $manageTemplatesWorkDaysOperation->addChild(Operations::DELETE_TEMPLATE_WORK_DAY);
        
        // Операции c заявками
        $a->createOperation(Operations::INDEX_ORDER, 'Список заявок');
        $a->createOperation(Operations::VIEW_ORDER, 'Посмотреть информацию о заявке');
        $a->createOperation(Operations::CREATE_ORDER, 'Создание заявки');
        $a->createOperation(Operations::UPDATE_ORDER, 'Обновить информацию о заявке');
        $a->createOperation(Operations::DELETE_ORDER, 'Удалиь заявку');
        
         // Все операции для просмотра заявок
        $viewOrdersOperation = $a->createOperation(Operations::VIEW_ORDERS, 'Смотреть информацию о заявках');
        $viewOrdersOperation->addChild(Operations::INDEX_ORDER);
        $viewOrdersOperation->addChild(Operations::VIEW_ORDER);
        
        // Все опрерации по управлению заявками
        $manageOrdersOperation = $a->createOperation(Operations::MANAGE_ORDERS, 'Управление заявками');
        $manageOrdersOperation->addChild(Operations::VIEW_ORDERS);
        $manageOrdersOperation->addChild(Operations::CREATE_ORDER);
        $manageOrdersOperation->addChild(Operations::UPDATE_ORDER);
        $manageOrdersOperation->addChild(Operations::DELETE_ORDER);
        
        //Операции с возможностями управления
        $a->createOperation(Operations::VIEW_CONFIG, 'Просмотр настроек');    
        $a->createOperation(Operations::PERFORM_ADMIN_ACTIONS, 'Выполнение действий для управления сайтом');
    
        $changeConfigOperation = $a->createOperation(Operations::CHANGE_CONFIG, 'Изменение настроек');
        $changeConfigOperation->addChild(Operations::VIEW_CONFIG);
        
        $manageApplicationOperation = $a->createOperation(Operations::MANAGE_APPLICATION, 'Управление сайтом');
        $manageApplicationOperation->addChild(Operations::CHANGE_CONFIG);
        $manageApplicationOperation->addChild(Operations::PERFORM_ADMIN_ACTIONS);
        
        // Общие действия.
        $a->createOperation(Operations::VIEW_ADMIN_MAIN, 'Главная страница администраторской части');
        
        $generalActionsOperation = $a->createOperation(Operations::GENERAL_ADMIN_ACTIONS, 'Общие действия администрирования');
        $generalActionsOperation->addChild(Operations::VIEW_ADMIN_MAIN);
        
        // Создаем роль admin 
        $adminRole = $a->createRole(User::ROLE_ADMIN, 'Администратор');
        $adminRole->addChild(Operations::LOGOUT);
        $adminRole->addChild(Operations::MANAGE_USERS);
        $adminRole->addChild(Operations::MANAGE_GROUPS);
        $adminRole->addChild(Operations::MANAGE_SPECIALIZATIONS);
        $adminRole->addChild(Operations::MANAGE_DOCTORS);
        $adminRole->addChild(Operations::MANAGE_SCHEDULE);
        $adminRole->addChild(Operations::MANAGE_TEMPLATE_WORK_DAYS);
        $adminRole->addChild(Operations::MANAGE_APPLICATION);
        $adminRole->addChild(Operations::MANAGE_ORDERS);
        $adminRole->addChild(Operations::GENERAL_ADMIN_ACTIONS);
        
        // Создаём роль editor
        $editorRole = $a->createRole(User::ROLE_EDITOR, 'Редактор');
        $editorRole->addChild(Operations::LOGOUT);
        $editorRole->addChild(Operations::MANAGE_GROUPS);
        $editorRole->addChild(Operations::MANAGE_SPECIALIZATIONS);
        $editorRole->addChild(Operations::MANAGE_DOCTORS);
        $editorRole->addChild(Operations::MANAGE_SCHEDULE);
        $editorRole->addChild(Operations::MANAGE_TEMPLATE_WORK_DAYS);
        $editorRole->addChild(Operations::MANAGE_ORDERS);
        $editorRole->addChild(Operations::GENERAL_ADMIN_ACTIONS);
        
        // Создаём роль operator
        $operatorRole = $a->createRole(User::ROLE_OPERATOR, 'Оператор');
        $operatorRole->addChild(Operations::LOGOUT);
        $operatorRole->addChild(Operations::VIEW_GROUPS);
        $operatorRole->addChild(Operations::VIEW_SPECIALIZATIONS);
        $operatorRole->addChild(Operations::VIEW_DOCTORS);
        $operatorRole->addChild(Operations::MANAGE_SCHEDULE);
        $operatorRole->addChild(Operations::MANAGE_TEMPLATE_WORK_DAYS);
        $operatorRole->addChild(Operations::MANAGE_ORDERS);
        $operatorRole->addChild(Operations::GENERAL_ADMIN_ACTIONS);
        
        // Связываем пользователей с ролями
        $this->assignRolesToExistingUsers($a);
        
        // Сохраняем роли и операции
        $a->save(); 
    }
    
    private function assignRolesToExistingUsers($authManager) {
        $connection = Yii::app()->db;
        
        $command = $connection->createCommand("SELECT id, role, enabled FROM {{user}} ");
        $dataReader = $command->query();
        
        while (($row = $dataReader->read() ) !== false) {
            $role = $row['role'];
            $id = $row['id'];
            $enabled = $row['enabled'];
            if ($enabled) {
                $authManager->assign($role, $id);
            }
        }
    }
    
    protected function performAjaxValidationFoApplicationrConfigFrom($model)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === self::UPDATE_APPLICATION_CONFIG_FORM_ID) )  
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}