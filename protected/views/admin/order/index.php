<?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

require_once '_defineMainMenu.php';
require_once '_defineOrderMenu.php';

$this->makeMenuItemActiveOnUrl($this->orderMenu, 'index');
 
$this->pageTitle = 'Заявки';

$this->additionalLayout = 'adminOrder';

Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/css/admin/lists/orderList.css');

$orderListId = 'orderList';
$orderSimpleUpdateDialogId = 'orderSimpleUpdateDialog';

if ($this->isUserCanModifyOrders) {    
    $this->renderPartial('//admin/common/_listItemAjaxDeleteScript', array('listId' => $orderListId) );
}

if ($this->isUserCanModifySchedule) { 
    $safeModifyDayDialogId = 'safeModifyDayDialog';
    $this->renderPartial('_safeModifyDayDialogScript',  array('safeModifyDayDialogId' => $safeModifyDayDialogId) );
}

$filterPanelData =
    array(
        array(
            'label' => 'Категория : ',
            'parameterName' => 'processed',
            'options' => array(
                'all' => 'Любая',
                'true' => 'Обработанные',
                'false' => 'Необработанные'
            ),
        ),
        array(
            'label' => 'Состояние : ',
            'parameterName' => 'state',
            'options' => array( 
                'all' => 'Любое',
                Order::STATE_NOT_DEFINED => 'Не определено',
                Order::STATE_RESOLVED => 'Принята',
                Order::STATE_REJECTED => 'Отклонённа'
            ),
        ),
    );

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
   Список заявок
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <div class="orderList">     
        <?php $this->renderPartial('//admin/common/_listAjaxInfo'); ?>
        <?php
             $this->widget(
                'AdvancedAdminListView',
                array(
                    'skin' => 'usingSorterPagerFilterPanel',
                    'id' => $orderListId, // Используется в js-функции updateList
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => 'Не найдено ни одной заявки.',
                    'sortableAttributes' => array(
                        'orderDateTime' => 'Время поступления заявки',
                        'dateTime' => 'Время приёма'
                    ),
                    'filterPanelData' => $filterPanelData, 
                )
            );
        ?>
    </div>
</div>
<?php
if ($this->isUserCanModifySchedule) {
    $this->renderPartial('_safeModifyDayDialog', array('safeModifyDayDialogId' => $safeModifyDayDialogId) );
}
