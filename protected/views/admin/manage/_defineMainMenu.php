<?php

$this->renderPartial('//admin/common/_defineMainMenu');
$this->makeMenuItemActiveOnUrl($this->mainMenu, '/admin/manage/config');