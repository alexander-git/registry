<?php

require_once '_defineMainMenu.php';
require_once '_defineOrderMenu.php';
$this->makeMenuItemActiveOnUrl($this->orderMenu, 'manage');

Yii::import('helpers.PublishHelper');

$this->additionalLayout = 'adminOrder';

$this->pageTitle = 'Управление заявками';

$this->renderPartial('//include/_dateIntervalAction');
$this->renderPartial('//include/_filterOrderItems');

$deleteOrdersId = 'deleteOrders';
$deleteOrdersUrl = $this->createUrl('/admin/order/deleteOrders');

$deleteOrdersFilterOrderItemsId = 'deleteFilterOrderItems';

Yii::app()->clientScript->registerScript(
   'manageOrders',
    "
    $(document).ready(function() {    
    
        var deleteOrdersFilterOrderItems = new FilterOrderItems('$deleteOrdersFilterOrderItemsId');

        var deleteOrdresAction = new DateIntervalAction('$deleteOrdersId', '$deleteOrdersUrl');
        deleteOrdresAction.setPrepareAdditionalDataBeforeRequestFunction(function() {
            var additionalData = deleteOrdersFilterOrderItems.getValues(); 
            return additionalData;
        });
        deleteOrdresAction.setIsRequiredAdditionalDataBeforeRequest(true);

    });
    ",
   CClientScript::POS_HEAD
); 

?>

<div class="mainBlockHeader -roundedCornersTop -pear">
   Управление заявками
</div>
<div class= "mainBlock -roundedCornersBottom -blue -blue--hrefDecoration">
    <div class="managePanel -roundedCorners -padding15">
        <div class="-marginBottom30">
            <h3>Удалить заявки</h3>
        </div>
        <?php $this->renderPartial('_filterOrderItems', array('id' => $deleteOrdersFilterOrderItemsId) ); ?>
        <div id="<?php echo $deleteOrdersId; ?>" class="-defaultInputItemsFont">
            <?php $this->renderPartial('_deleteOrdersItems', array('dateInputNameSuffix' =>'delteOrders') ); ?>
        </div>
    </div>
</div>