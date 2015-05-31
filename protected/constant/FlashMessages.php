<?php

class FlashMessages {
  
    const USER_CREATE_SUCCESS = 'Пользователь успешно создан';
    const USER_UPDATE_SUCCESS = 'Пользователь успешно изменен';
    
    const GROUP_CREATE_SUCCESS = 'Группа успешно создана';
    const GROUP_UPDATE_SUCCESS = 'Группа успешно изменена';
    const DELETING_GROUP_WHICH_HAS_SPECIALIZATIONS_ERROR = 'Нельзя удалить группу у которой есть специализации';
    
    const SPECIALIZATION_CREATE_SUCCESS = 'Специализация успешно создана';
    const SPECIALIZATION_UPDATE_SUCCESS = 'Специализация успешно изменена';
    const DELETING_SPECIALIZATION_WHICH_HAS_DOCTORS_ERROR = 'Нельзя удалить специализацию у которой есть врачи';
    const DELETING_SPECIALIZATION_WHICH_IN_WORK_DAYS_ERROR = 'Нельзя удалить специализацию, для которой создано рассписание';
    const DELETING_SPECIALIZATION_WHICH_IN_ORDERS_ERROR = 'Нельзя удалить специализацию, которая есть в заявках';
    
    const DOCTOR_CREATE_SUCCESS = 'Врач успешно создан';
    const DOCTOR_UPDATE_SUCCESS = 'Врач успешно изменён';
    const DELETING_DOCTOR_WHICH_IN_WORK_DAYS_ERROR = 'Нельзя удалить врча, для которого создано рассписание';
    const DELETING_DOCTOR_WHICH_IN_ORDERS_ERROR = 'Нельзя удалить врача, которая есть в заявках';
    
    const TEMPLATE_WORK_DAY_CREATE_SUCCESS = 'Шаблон успешно создан';
    const TEMPLATE_WORK_DAY_UPDATE_SUCCESS = 'Шаблон успешно изменен';
    
    const ORDER_CREATE_SUCCESS = 'Заявка успешно создана';
    const ORDER_UPDATE_SUCCESS = 'Заявка успешно изменена';
    
    const APPLICATION_CONFIG_UPDATE_SUCCESS = 'Настройки успешно изменены';
    
    private function __construct() {
    
    }
}
