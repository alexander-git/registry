<?php
/* @var $this TemplateWorkDayController */
/* @var $dataProvider CActiveDataProvider */

require_once '_defineMainMenu.php';
require_once '_defineTemplateWorkDayMenu.php';
$this->makeMenuItemActiveOnUrl($this->templateWorkDayMenu, 'index');
 
$this->pageTitle = 'Список шаблонов';
$this->additionalLayout = 'adminTemplateWorkDay';

Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/css/admin/lists/templateWorkDayList.css');

$templateWorkDayListId = 'templateWorkDayList';
if ($this->isUserCanModifyTemplateWorkDays) {
    $this->renderPartial('//admin/common/_listItemAjaxDeleteScript', array('listId' => $templateWorkDayListId) );
}

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Список шаблонов
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <div class="templateWorkDayList">
        <?php $this->renderPartial('//admin/common/_listAjaxInfo'); ?>
        <?php
             $this->widget(
                'AdvancedAdminListView',
                array(
                    'skin' => 'usingSorterPager',
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'id' => $templateWorkDayListId, // Используется в js-функции updateList
                    'sortableAttributes' => array(
                        'name' => 'Имя шаблона',
                    ),
                    'emptyText' => 'Не найдено ни одного шаблона.',
                )
            );
        ?>
    </div>
</div>