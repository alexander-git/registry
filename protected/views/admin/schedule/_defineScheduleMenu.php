<?php

$this->scheduleMenu = array(
        array('label' => 'Выбрать', 'url' => array('index') )
);

if ($this->isUserCanModifySchedule) {
    array_push(
        $this->scheduleMenu, 
        array('label' => 'Управление', 'url' => array('manage') )
    );    
}
