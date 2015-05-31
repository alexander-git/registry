<?php

$this->templateWorkDayMenu = array(
        array('label' => 'Список', 'url' => array('index') )
);

if ($this->isUserCanModifyTemplateWorkDays) {
    array_push(
        $this->templateWorkDayMenu, 
        array('label' => 'Создать', 'url' => array('create') )
    );    
}
