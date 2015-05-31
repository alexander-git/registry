<?php

class Operations {

    const LOGOUT = 'logout';
    
    // Операции с пользователями.
    const INDEX_USER = 'indexUser';
    const VIEW_USER = 'viewUser';
    const CREATE_USER = 'createUser';
    const UPDATE_USER = 'updateUser';
    const DELETE_USER = 'deleteUser';
    
    const VIEW_USERS = 'viewUsers';
    const MANAGE_USERS = 'manageUsers';
    
    // Операции с группами.
    const INDEX_GROUP = 'indexGroup';
    const VIEW_GROUP = 'viewGroup';
    const CREATE_GROUP = 'createGroup';
    const UPDATE_GROUP = 'updateGroup';
    const DELETE_GROUP = 'deleteGroup';
    
    const VIEW_GROUPS = 'viewGroups';
    const MANAGE_GROUPS = 'manageGroup';
    
    // Операции со специализациями.
    const INDEX_SPECIALIZATION = 'indexSpecialization';
    const VIEW_SPECIALIZATION = 'viewSpecialization';
    const CREATE_SPECIALIZATION = 'createSpecialization';
    const UPDATE_SPECIALIZATION = 'updateSpecialization';
    const DELETE_SPECIALIZATION = 'deleteSpecialization';
    
    const VIEW_SPECIALIZATIONS = 'viewSpecializations';
    const MANAGE_SPECIALIZATIONS = 'manageSpecializations';
    
    // Операции с врачами.
    const INDEX_DOCTOR = 'indexDoctor';
    const VIEW_DOCTOR = 'viewDoctor';
    const CREATE_DOCTOR = 'createDoctor';
    const UPDATE_DOCTOR = 'updateDoctor';
    const DELETE_DOCTOR = 'deleteDoctor';
    
    const VIEW_DOCTORS = 'viewDoctors';
    const MANAGE_DOCTORS = 'manageDoctors';
    
    // Операции с рассписанием.
    const VIEW_SCHEDULE = 'viewSchedule';
    const MANAGE_SCHEDULE = 'manageSchedule';
    
    // Операции с шаблонами.
    const INDEX_TEMPLATE_WORK_DAY = 'indexTemplateWorkDay';
    const VIEW_TEMPLATE_WORK_DAY = 'viewTemplateWorkDay';
    const CREATE_TEMPLATE_WORK_DAY = 'createTemplateWorkDay';
    const UPDATE_TEMPLATE_WORK_DAY = 'updateTemplateWorkDay';
    const DELETE_TEMPLATE_WORK_DAY = 'deleteTemplateWorkDay';
    
    const VIEW_TEMPLATE_WORK_DAYS = 'viewTemplateWorkDays';
    const MANAGE_TEMPLATE_WORK_DAYS = 'manageTemplateWorkDays';
    
    // Операции с заявками.
    const INDEX_ORDER = 'indexOrder';
    const VIEW_ORDER = 'viewOrder';
    const CREATE_ORDER = 'createOrder';
    const UPDATE_ORDER = 'updateOrder';
    const DELETE_ORDER = 'deleteOrder';
    
    const VIEW_ORDERS = 'viewOrders';
    const MANAGE_ORDERS = 'manageOrders';
    
    // Опрации с общими настройками и управлением сайта.
    const VIEW_CONFIG = 'viewConfig';
    const CHANGE_CONFIG = 'changeConfig';
    const PERFORM_ADMIN_ACTIONS = 'performAdminActions';
    const MANAGE_APPLICATION = 'manageApplication';
    
    // Общие действия.
    const VIEW_ADMIN_MAIN = 'viewAdminMain';
    const GENERAL_ADMIN_ACTIONS = 'generalAdminActions';
    
    private function __construct() {
        
    }
    
}