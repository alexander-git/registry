<?php

$this->orderMenu = array(
        array('label' => 'Список', 'url' => array('index') ),
);

if ($this->isUserCanModifyOrders) {
    array_push(
        $this->orderMenu, 
        array('label' => 'Создать', 'url' => array('create') ),
        array('label' => 'Управление', 'url' => array('manage') )
    );    
}
