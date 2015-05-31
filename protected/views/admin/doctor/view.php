<?php
/* @var $this DoctorController */
/* @var $model Doctor */

$this->pageTitle = 'Информация о враче';
$this->additionalLayout = 'adminDoctor';

require_once '_defineMainMenu.php';
require_once '_defineDoctorMenu.php';

$this->renderPartial('//include/_tableView');

if ($this->isUserCanModifyDoctors) {
    $this->renderPartial('//admin/common/_itemDeleteConfirmationScript');
}

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Информация о враче
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
                    'additional',
                    'speciality',
                    array(
                        'label' => 'Состояние',
                        'name' => 'enabled',
                        'type' => 'enabled'
                    ),
                    array(
                        'label' => 'Специализация(и)',
                        'name' => 'specializations',
                        'type' => 'specializations'
                    ),
                    array(
                        'label' => 'Доп. информация',
                        'name' => 'info',
                        'type' => 'info'
                    ),  
                ),
                'formatter' => new DoctorInfoFormatter(),
            )
        );
        ?>  
        <div class="-hidden -tableView--cellParameters">
            hidden
        </div>
        <?php if ($this->isUserCanModifyDoctors) : ?>
            <div class="-padding10 -marginTop20">
                <div class="buttonsRow buttonsRow--usingLinkButtons">
                    <?php 
                        echo CHtml::link(
                            'Изменить', 
                            array(
                                'admin/doctor/update', 
                                 'id' => $model->id,
                            ),
                            array('class' => 'linkButton linkButton--default -azure -azure--action')
                        );
                    ?>
                    
                    <?php 
                        echo CHtml::link(
                            'Удалить', 
                            array(
                                'admin/doctor/delete', 
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