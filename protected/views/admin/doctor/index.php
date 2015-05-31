<?php
/* @var $this DoctorController */
/* @var $dataProvider CActiveDataProvider */

require_once '_defineMainMenu.php';
require_once '_defineDoctorMenu.php';
$this->makeMenuItemActiveOnUrl($this->doctorMenu, 'index');
 
$this->pageTitle = 'Список врачей';

$this->additionalLayout = 'adminDoctor';

Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/css/admin/lists/doctorList.css');

$doctorListId = 'doctorList';

if ($this->isUserCanModifyDoctors) {
    $this->renderPartial('//admin/common/_listItemAjaxDeleteScript', array('listId' => $doctorListId) );
}

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
    Список врачей
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <div class=doctorList">
        <?php $this->renderPartial('//admin/common/_listAjaxInfo'); ?>
        <?php
             $this->widget(
                'AdvancedAdminListView',
                array(
                    'skin' => 'usingSorterPagerFilterPanel',
                    'id' => $doctorListId, // Используется в js-функции updateList
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'sortableAttributes' => array(
                        'firstname' => 'Имя',
                        'surname' => 'Фамилия',
                        'patronymic' => 'Отчество',
                        'speciality' => 'Специальность'
                    ),
                    'emptyText' => 'Не найдено ни одного врача.',
                    'filterPanelData' => $filterPanelData,               
                )
            );
        ?>
    </div>
</div>