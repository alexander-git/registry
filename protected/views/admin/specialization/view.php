<?php
/* @var $this SpecializationController */
/* @var $model Specialization */

$this->pageTitle = 'Информация о специализации';
$this->additionalLayout = 'adminSpecialization';

require_once '_defineMainMenu.php';
require_once '_defineSpecializationMenu.php';

$this->renderPartial('//include/_tableView');


if ($this->isUserCanModifySpecializations) {
    $this->renderPartial('//admin/common/_itemDeleteConfirmationScript');
}

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Информация о специализации
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
                    'name',
                    'additional',
                    array(
                        'label' => 'Состояние',
                        'name' => 'enabled',
                        'type' => 'enabled'
                    ),
                    array(
                        'name' => 'needDoctor',
                        'type' => 'needDoctor'
                    ),
                    array(
                        'name' => 'recordOnTime',
                        'type' => 'recordOnTime'
                    ),
                     array(
                        'name' => 'provisionalRecord',
                        'type' => 'provisionalRecord'
                    ),
                    array (
                        'label' => 'Группа',
                        'name' => 'group.name',
                        'type' => 'groupName'
                    ),
                ),
                'formatter' => new SpecializationInfoFormatter(),
            )
        );
        ?>  
        
         <?php if(count($model->doctors) > 0) : ?>
            <div class="-padding10 -jqui -jqui--useAzureAccordion">
                <?php 
                    $this->widget('zii.widgets.jui.CJuiAccordion',
                            array(
                                'skin' => 'collapsedUsingMainTheme',
                                'panels' => array(
                                    'Врачи' => 
                                        $this->renderPartial(
                                            '_doctors', 
                                            array('doctors' => $model->doctors), 
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
        <?php if ($this->isUserCanModifySpecializations) : ?>
            <div class="-padding10 -marginTop20">
                <div class="buttonsRow buttonsRow--usingLinkButtons">
                    <?php 
                        echo CHtml::link(
                            'Изменить', 
                            array(
                                'admin/specialization/update', 
                                 'id' => $model->id,
                            ),
                            array('class' => 'linkButton linkButton--default -azure -azure--action')
                        );
                    ?>
                    
                    <?php 
                        echo CHtml::link(
                            'Удалить', 
                            array(
                                'admin/specialization/delete', 
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