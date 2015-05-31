<?php

$this->groupMenu = array(
        array('label' => 'Список', 'url' => array('index') )
);

if ($this->isUserCanModifyGroups) {
    array_push(
        $this->groupMenu, 
        array('label' => 'Создать', 'url' => array('create') )
    );    
}
