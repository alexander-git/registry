<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

require_once '_defineMainMenu.php';
require_once '_defineUserMenu.php';
$this->makeMenuItemActiveOnUrl($this->userMenu, 'index');

$this->pageTitle = 'Список пользователей';
$this->additionalLayout = 'adminUser';

Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/css/admin/lists/userList.css');

$userListId = 'userList';

$this->renderPartial('//admin/common/_listItemAjaxDeleteScript', array('listId' => $userListId) );

$filterPanelData =
    array(
        array(
            'label' => 'Состояние : ',
            'parameterName' => 'enabled',
            'options' => array( 
                'all' => 'Любое',
                'enabled' => 'Включён',
                'disabled' => 'Отключён'
            ),
        ),
    );

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Список пользователей
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <div class="userList">
        <?php $this->renderPartial('//admin/common/_listAjaxInfo'); ?>
        <?php
             $this->widget('AdvancedAdminListView', array(
                    'skin' => 'usingSorterPagerFilterPanel',
                    'id' => $userListId,   
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'sortableAttributes' => array(
                              'name' => 'Логин', 
                              'firstname' => 'Имя',
                              'surname' => 'Фамилия',
                              'patronymic' => 'Отчество',
                      ),
                    'emptyText' => 'Не создано ни одного пользователя.',
                    'filterPanelData' => $filterPanelData,
                )
            );
        ?>
    </div>
</div>