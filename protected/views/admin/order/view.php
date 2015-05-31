<?php
/* @var $this OrderController */
/* @var $model Order */

$this->pageTitle = 'Информация о заявке';
$this->additionalLayout = 'adminOrder';

require_once '_defineMainMenu.php';
require_once '_defineOrderMenu.php';

$this->renderPartial('//include/_tableView');


if ($this->isUserCanModifyOrders) {
    $this->renderPartial('//admin/common/_itemDeleteConfirmationScript');
    
    $safeModifyDayDialogId = 'safeModifyDayDialog';
    $this->renderPartial('_safeModifyDayDialogScript',  array('safeModifyDayDialogId' => $safeModifyDayDialogId) );
}

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Информация о заявке
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <?php $this->renderPartial('//admin/common/_successFlashMessage'); ?>
    <?php $this->renderPartial('//admin/common/_errorFlashMessage'); ?>
    <div class="-roundedCorners -cyan -margin10">
        <?php $this->widget('NullFormatDetailView', 
            array(
                'skin' => 'usingTableView',
                'data' => $model,
                
                'attributes'=>array(
                    'surname',
                    'firstname',
                    'patronymic',
                    'phone',
                    array(
                        'name' => 'date',
                        'type' => 'date'
                    ),
                    array(
                        'name' => 'time',
                        'type' => 'time'
                    ),
                    array(
                        'label' => 'Специализация',
                        'name' => 'specialization',
                        'type' => 'specialization'
                    ),
                    array(
                        'label' => 'Врач',
                        'name' => 'doctor',
                        'type' => 'doctor'
                    ),
                    array(
                        'label' => 'Обработана',
                        'name' => 'processed',
                        'type' => 'processed'
                    ),
                    array(
                        'name' => 'state',
                        'type' => 'state'
                    ),
                    array(
                        'name' => 'orderDateTime',
                        'type' => 'orderDateTime'
                    )
                ),
                'formatter' => new OrderInfoFormatter(),
            )
        );
        ?>  
        
        <div class="-hidden -tableView--cellParameters">
            hidden
        </div>
        <?php if (($this->isUserCanModifyOrders) || ($this->isUserCanModifySchedule) )  : ?>
            <div class="-padding10 -marginTop20">               
                <div class="buttonsRow buttonsRow--usingLinkButtons">
                    <?php if ($this->isUserCanModifyOrders) : ?>
                        <?php 
                            echo CHtml::link(
                                'Изменить', 
                                array(
                                    'admin/order/update', 
                                     'id' => $model->id,
                                ),
                                array('class' => 'linkButton linkButton--default -azure -azure--action')
                            );
                        ?>

                        <?php 
                            echo CHtml::link(
                                'Удалить', 
                                array(
                                    'admin/order/delete', 
                                     'id' => $model->id,
                                ),
                                array('class' => 'linkButton linkButton--default -azure -azure--action -jsItemDeleteConfirmation')
                            );
                        ?>   
                    <?php endif; ?>
                    
                    <?php if ($this->isUserCanModifySchedule) : ?>
                        <div class="orderInfoStore -inlineBlock">
                            <?php $this->renderPartial('_orderInfoStoreDataContainer', array('order' => $model) ); ?>
                            <div class="linkButton linkButton--default -azure -azure--action -jsSafeModifyDayDialogButton -cursorPointer" style="width : 250px;">
                                Изменить время в расписании
                            </div>
                        </div> 
                    <?php endif; ?>
                </div>               
            </div>  
        <?php endif; ?>               
    </div>
</div>
<?php
    if ($this->isUserCanModifyOrders) {
        $this->renderPartial('_safeModifyDayDialog', array('safeModifyDayDialogId' => $safeModifyDayDialogId) );
    }