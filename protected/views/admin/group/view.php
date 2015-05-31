<?php
/* @var $this GroupController */
/* @var $model Group */

$this->pageTitle = 'Информация о группе';
$this->additionalLayout = 'adminGroup';

require_once '_defineMainMenu.php';
require_once '_defineGroupMenu.php';

$this->renderPartial('//include/_tableView');

if ($this->isUserCanModifyGroups) {
    $this->renderPartial('//admin/common/_itemDeleteConfirmationScript');
}

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Информация о группе
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <?php $this->renderPartial('//admin/common/_successFlashMessage'); ?>
    <?php $this->renderPartial('//admin/common/_errorFlashMessage'); ?>
    <div class="-roundedCorners -cyan -margin10">        
        <?php $this->widget('zii.widgets.CDetailView', 
            array(
                'skin' => 'usingTableView',
                'data' => $model,
                'attributes'=>array(
                    'name',
                    array(
                        'label' => 'Состояние',
                        'name' => 'enabled',
                        'type' => 'enabled'
                    ),
                ),
                'formatter' => new GroupInfoFormatter(),
            )
        );
        ?>  
        
        <?php if(count($model->specializations) > 0) : ?>
            <div class="-padding10 -jqui -jqui--useAzureAccordion">
                <?php 
                    $this->widget('zii.widgets.jui.CJuiAccordion',
                        array(
                            'skin' => 'collapsedUsingMainTheme',
                            'panels' => array(
                                'Специализации' => 
                                    $this->renderPartial(
                                        '_specializations', 
                                        array('specializations' => $model->specializations), 
                                        true
                                    ),
                            ),        
                        )
                    ); 
                ?>
            </div>
        <?php endif; ?>
        
        <div class="-hidden -tableView--cellParameters">
            hidden
        </div>
        <?php if ($this->isUserCanModifyGroups) : ?>
            <div class="-padding10 -marginTop20">
                <div class="buttonsRow buttonsRow--usingLinkButtons">
                    <?php 
                        echo CHtml::link(
                            'Изменить', 
                            array(
                                'admin/group/update', 
                                 'id' => $model->id,
                            ),
                            array('class' => 'linkButton linkButton--default -azure -azure--action')
                        );
                    ?>
                    
                    <?php 
                        echo CHtml::link(
                            'Удалить', 
                            array(
                                'admin/group/delete', 
                                 'id' => $model->id,
                            ),
                            array('class' => 'linkButton linkButton--default -azure -azure--action -jsItemDeleteConfirmation')
                        );
                    ?>
                </div>
            </div>  
        <?php endif; ?>
    </div>
</div>