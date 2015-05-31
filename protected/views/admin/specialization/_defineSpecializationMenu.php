<?php

$this->specializationMenu = array(
        array('label' => 'Список', 'url' => array('index') )
);

if ($this->isUserCanModifySpecializations) {
    array_push(
        $this->specializationMenu, 
        array('label' => 'Создать', 'url' => array('create') )
    );    
}
