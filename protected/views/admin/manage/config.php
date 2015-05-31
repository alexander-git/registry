<?php
/* @var $this ManageController */

require_once '_defineMainMenu.php';
require_once '_defineManageMenu.php';
$this->makeMenuItemActiveOnUrl($this->manageMenu, 'config');

$this->additionalLayout = 'adminManage';

$this->pageTitle = 'Изменение настроек';

$this->renderPartial('//include/_tableForm');

?>

<div class="mainBlockHeader -roundedCornersTop -pear">
   Изменение настроек
</div>
<div class= "mainBlock -blue -roundedCornersBottom">
    <div class="-padding15">
        <?php $this->renderPartial('//admin/common/_successFlashMessage'); ?>
        <?php $this->renderPartial('//admin/common/_errorFlashMessage'); ?>
        <?php $this->renderPartial('_configForm', array('model' => $model) ); ?>   
    </div>
</div>