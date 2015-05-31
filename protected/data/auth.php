<?php
return array (
  'logout' => 
  array (
    'type' => 0,
    'description' => 'Выход',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'indexUser' => 
  array (
    'type' => 0,
    'description' => 'Список пользователей для изменения',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewUser' => 
  array (
    'type' => 0,
    'description' => 'Посмотреть информацию о пользователе',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createUser' => 
  array (
    'type' => 0,
    'description' => 'Создание пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateUser' => 
  array (
    'type' => 0,
    'description' => 'Редектирование пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteUser' => 
  array (
    'type' => 0,
    'description' => 'Удаление пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewUsers' => 
  array (
    'type' => 0,
    'description' => 'Управление пользователями',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'indexUser',
      1 => 'viewUser',
    ),
  ),
  'manageUsers' => 
  array (
    'type' => 0,
    'description' => 'Управление пользователями',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewUsers',
      1 => 'createUser',
      2 => 'updateUser',
      3 => 'deleteUser',
    ),
  ),
  'indexGroup' => 
  array (
    'type' => 0,
    'description' => 'Список групп',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewGroup' => 
  array (
    'type' => 0,
    'description' => 'Посмотреть информацию о группе',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createGroup' => 
  array (
    'type' => 0,
    'description' => 'Создание группы',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateGroup' => 
  array (
    'type' => 0,
    'description' => 'Обновить информацию о группе',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteGroup' => 
  array (
    'type' => 0,
    'description' => 'Удалиь группу',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewGroups' => 
  array (
    'type' => 0,
    'description' => 'Смотреть информацию о группах',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'indexGroup',
      1 => 'viewGroup',
    ),
  ),
  'manageGroup' => 
  array (
    'type' => 0,
    'description' => 'Управление группами',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewGroups',
      1 => 'createGroup',
      2 => 'updateGroup',
      3 => 'deleteGroup',
    ),
  ),
  'indexSpecialization' => 
  array (
    'type' => 0,
    'description' => 'Список специализаций',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewSpecialization' => 
  array (
    'type' => 0,
    'description' => 'Посмотреть информацию о специализации',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createSpecialization' => 
  array (
    'type' => 0,
    'description' => 'Создание специализации',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateSpecialization' => 
  array (
    'type' => 0,
    'description' => 'Обновить информацию о специализации',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteSpecialization' => 
  array (
    'type' => 0,
    'description' => 'Удалиь специализацию',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewSpecializations' => 
  array (
    'type' => 0,
    'description' => 'Смотреть информацию о специализациях',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'indexSpecialization',
      1 => 'viewSpecialization',
    ),
  ),
  'manageSpecializations' => 
  array (
    'type' => 0,
    'description' => 'Управление специализациями',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewSpecializations',
      1 => 'createSpecialization',
      2 => 'updateSpecialization',
      3 => 'deleteSpecialization',
    ),
  ),
  'indexDoctor' => 
  array (
    'type' => 0,
    'description' => 'Список врачей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewDoctor' => 
  array (
    'type' => 0,
    'description' => 'Посмотреть информацию о враче',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createDoctor' => 
  array (
    'type' => 0,
    'description' => 'Создание врача',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateDoctor' => 
  array (
    'type' => 0,
    'description' => 'Обновить информацию о враче',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteDoctor' => 
  array (
    'type' => 0,
    'description' => 'Удалиь врача',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewDoctors' => 
  array (
    'type' => 0,
    'description' => 'Смотреть информацию о врачах',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'indexDoctor',
      1 => 'viewDoctor',
    ),
  ),
  'manageDoctors' => 
  array (
    'type' => 0,
    'description' => 'Управление врачами',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewDoctors',
      1 => 'createDoctor',
      2 => 'updateDoctor',
      3 => 'deleteDoctor',
    ),
  ),
  'viewSchedule' => 
  array (
    'type' => 0,
    'description' => 'Просмотр рассписания',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'manageSchedule' => 
  array (
    'type' => 0,
    'description' => 'Изменение рассписания',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewSchedule',
    ),
  ),
  'indexTemplateWorkDay' => 
  array (
    'type' => 0,
    'description' => 'Список шаблонов рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewTemplateWorkDay' => 
  array (
    'type' => 0,
    'description' => 'Посмотреть информацию о шаблоне рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createTemplateWorkDay' => 
  array (
    'type' => 0,
    'description' => 'Создание шаблона рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateTemplateWorkDay' => 
  array (
    'type' => 0,
    'description' => 'Редектирование  шаблона рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteTemplateWorkDay' => 
  array (
    'type' => 0,
    'description' => 'Удаление  шаблона рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewTemplateWorkDays' => 
  array (
    'type' => 0,
    'description' => 'Смотреть информации о шаблонах рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'indexTemplateWorkDay',
      1 => 'viewTemplateWorkDay',
    ),
  ),
  'manageTemplateWorkDays' => 
  array (
    'type' => 0,
    'description' => 'Управление шаблонами рабочего дня',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewTemplateWorkDays',
      1 => 'createTemplateWorkDay',
      2 => 'updateTemplateWorkDay',
      3 => 'deleteTemplateWorkDay',
    ),
  ),
  'indexOrder' => 
  array (
    'type' => 0,
    'description' => 'Список заявок',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewOrder' => 
  array (
    'type' => 0,
    'description' => 'Посмотреть информацию о заявке',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createOrder' => 
  array (
    'type' => 0,
    'description' => 'Создание заявки',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateOrder' => 
  array (
    'type' => 0,
    'description' => 'Обновить информацию о заявке',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteOrder' => 
  array (
    'type' => 0,
    'description' => 'Удалиь заявку',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewOrders' => 
  array (
    'type' => 0,
    'description' => 'Смотреть информацию о заявках',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'indexOrder',
      1 => 'viewOrder',
    ),
  ),
  'manageOrders' => 
  array (
    'type' => 0,
    'description' => 'Управление заявками',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewOrders',
      1 => 'createOrder',
      2 => 'updateOrder',
      3 => 'deleteOrder',
    ),
  ),
  'viewConfig' => 
  array (
    'type' => 0,
    'description' => 'Просмотр настроек',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'performAdminActions' => 
  array (
    'type' => 0,
    'description' => 'Выполнение действий для управления сайтом',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'changeConfig' => 
  array (
    'type' => 0,
    'description' => 'Изменение настроек',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewConfig',
    ),
  ),
  'manageApplication' => 
  array (
    'type' => 0,
    'description' => 'Управление сайтом',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'changeConfig',
      1 => 'performAdminActions',
    ),
  ),
  'viewAdminMain' => 
  array (
    'type' => 0,
    'description' => 'Главная страница администраторской части',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'generalAdminActions' => 
  array (
    'type' => 0,
    'description' => 'Общие действия администрирования',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewAdminMain',
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => 'Администратор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'logout',
      1 => 'manageUsers',
      2 => 'manageGroup',
      3 => 'manageSpecializations',
      4 => 'manageDoctors',
      5 => 'manageSchedule',
      6 => 'manageTemplateWorkDays',
      7 => 'manageApplication',
      8 => 'manageOrders',
      9 => 'generalAdminActions',
    ),
    'assignments' => 
    array (
      1 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'editor' => 
  array (
    'type' => 2,
    'description' => 'Редактор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'logout',
      1 => 'manageGroup',
      2 => 'manageSpecializations',
      3 => 'manageDoctors',
      4 => 'manageSchedule',
      5 => 'manageTemplateWorkDays',
      6 => 'manageOrders',
      7 => 'generalAdminActions',
    ),
    'assignments' => 
    array (
      3 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'operator' => 
  array (
    'type' => 2,
    'description' => 'Оператор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'logout',
      1 => 'viewGroups',
      2 => 'viewSpecializations',
      3 => 'viewDoctors',
      4 => 'manageSchedule',
      5 => 'manageTemplateWorkDays',
      6 => 'manageOrders',
      7 => 'generalAdminActions',
    ),
    'assignments' => 
    array (
      2 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
);
