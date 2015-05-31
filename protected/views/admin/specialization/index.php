<?php
/* @var $this SpecializationController */
/* @var $dataProvider CActiveDataProvider */

require_once '_defineMainMenu.php';
require_once '_defineSpecializationMenu.php';
$this->makeMenuItemActiveOnUrl($this->specializationMenu, 'index');
 
$this->pageTitle = 'Список специализаций';

$this->additionalLayout = 'adminSpecialization';

Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/css/admin/lists/specializationList.css');

$specializationListId = 'specializationList';

if ($this->isUserCanModifySpecializations) {
    $this->renderPartial('//admin/common/_listItemAjaxDeleteScript', array('listId' => $specializationListId) );
}

// Формируем данные для панели фильтрации
$groups =  CHtml::listData(
        array_merge(               
            array(
                array('id' => 'all', 'name' => 'Любая'), 
                array('id' => 'null', 'name' =>'Не указано') 
            ),
            Group::model()->findAll()
        ),
        'id', 
        'name'
    );

$filterPanelData =
    array(
        array(
            'label' => 'Группа : ',
            'parameterName' => 'idGroup',
            'options' => $groups
        ),
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
    Список специализаций
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <div class="specializationList">     
        <?php $this->renderPartial('//admin/common/_listAjaxInfo'); ?>
        <?php
             $this->widget(
                'AdvancedAdminListView',
                array(
                    'skin' => 'usingSorterPagerFilterPanel',
                    'id' => $specializationListId, // Используется в js-функции updateList
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => 'Не найдено ни одной специализации.',
                    'sortableAttributes' => array(
                        'name' => 'Имя специализации',
                    ),
                    'filterPanelData' => $filterPanelData,
                    
                )
            );
        ?>
    </div>
</div>