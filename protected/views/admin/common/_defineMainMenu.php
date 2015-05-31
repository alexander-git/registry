<?php


/*
// Вариант без проверки прав доступа.
$this->mainMenu =array(
    array('label' => 'Главная', 'url' => array('/') ),
    array('label' => 'Пользователи', 'url' => array('/admin/user/index') ),
    array('label' => 'Группы', 'url' => array('/admin/group/index') ),
    array('label' => 'Специализации', 'url'=>array('/admin/specialization/index') ),
    array('label' => 'Врачи', 'url'=>array('/admin/doctor/index') ),
    array('label' => 'Расписание', 'url' => array('/admin/schedule/index') ),
    array('label' => 'Шаблоны', 'url' => array('/admin/templateWorkDay/index') ),
    array('label' => 'Заявки', 'url' => array('/admin/order/index') ),
    array('label' => 'Управление', 'url' => array('/admin/manage/config') ),
);
*/

$this->mainMenu = array();

array_push($this->mainMenu, array('label' => 'Главная', 'url' => array('/') ) );
if ($this->isUserCanViewUsers) {
    array_push($this->mainMenu, array('label' => 'Пользователи', 'url' => array('/admin/user/index') ) ); 
}
if ($this->isUserCanViewGroups) {
    array_push($this->mainMenu, array('label' => 'Группы', 'url' => array('/admin/group/index') ) ); 
}
if ($this->isUserCanViewSpecializations) {
    array_push($this->mainMenu, array('label' => 'Специализации', 'url'=>array('/admin/specialization/index') ) );
}
if ($this->isUserCanViewDoctors) {
    array_push($this->mainMenu, array('label' => 'Врачи', 'url'=>array('/admin/doctor/index') ) );
}
if ($this->isUserCanViewSchedule) {
    array_push($this->mainMenu, array('label' => 'Расписание', 'url' => array('/admin/schedule/index') ) );
}
if ($this->isUserCanViewTemplateWorkDays) {
    array_push($this->mainMenu, array('label' => 'Шаблоны', 'url' => array('/admin/templateWorkDay/index') ) ); 
}
if ($this->isUserCanViewOrders) {
    array_push($this->mainMenu, array('label' => 'Заявки', 'url' => array('/admin/order/index') ) );  
}
if ($this->isUserCanManageApplication) {
    array_push($this->mainMenu, array('label' => 'Управление', 'url' => array('/admin/manage/config') ) );
}