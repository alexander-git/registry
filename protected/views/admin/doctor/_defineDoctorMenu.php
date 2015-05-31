<?php

$this->doctorMenu = array(
        array('label' => 'Список', 'url' => array('index') ),
);

if ($this->isUserCanModifyDoctors) {
    array_push(
        $this->doctorMenu, 
        array('label' => 'Создать', 'url' => array('create') )
    );    
}
