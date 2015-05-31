<?php
/* @var $this GroupController */
/* @var $dataProvider CActiveDataProvider */

require_once '_defineMainMenu.php';
require_once '_defineGroupMenu.php';
$this->makeMenuItemActiveOnUrl($this->groupMenu, 'index');
 
$this->pageTitle = 'Список групп';

$this->additionalLayout = 'adminGroup';

Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/css/admin/lists/groupList.css');

$groupListId = 'groupList';

if ($this->isUserCanModifyGroups) {
    $this->renderPartial('//admin/common/_listItemAjaxDeleteScript', array('listId' => $groupListId) );
}

$filterPanelData =
    array(
        array(
            'label' => 'Состояние : ',
            'parameterName' => 'enabled',
            'options' => array( 
                'all' => 'Любое',
                'enabled' => 'Включёна',
                'disabled' => 'Отключёна'
            ),
        ),
    );

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Список групп
</div>
<div class= "mainBlock -roundedCornersBottom -blue">    
    <div class="groupList">
        <?php $this->renderPartial('//admin/common/_listAjaxInfo'); ?>
        <?php
             $this->widget(
                'AdvancedAdminListView',
                array(
                    'skin' => 'usingSorterPagerFilterPanel',
                    'id' => $groupListId, // Используется в js-функции updateList
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'sortableAttributes' => array(
                        'name' => 'Имя группы', 
                    ),
                    'emptyText' => 'Не найдено ни одной группы.',
                    'filterPanelData' => $filterPanelData, 
                )
            );
        ?>
    </div>
</div>