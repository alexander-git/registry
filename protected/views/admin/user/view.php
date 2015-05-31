<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Информация о пользователе';
$this->additionalLayout = 'adminUser';

require_once '_defineMainMenu.php';
require_once '_defineUserMenu.php';

$this->renderPartial('//include/_tableView');
$this->renderPartial('//admin/common/_itemDeleteConfirmationScript');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Информация о пользователе
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
                    'password',
                    'surname',
                    'firstname',
                    'patronymic',
                    array(
                        'name' => 'role',
                        'type' => 'role'
                    ),
                    array(
                        'label' => 'Состояние',
                        'name' => 'enabled',
                        'type' => 'enabled'
                    )
                ),
                'formatter' => new UserInfoFormatter(),
            )
        );
        ?>  
        
        <div class="-padding10 -marginTop50">
            <div class="buttonsRow buttonsRow--usingLinkButtons">
                <?php 
                    echo CHtml::link(
                        'Изменить', 
                        array('admin/user/update', 'id' => $model->id),
                        array('class' => 'linkButton linkButton--default -azure -azure--action')
                    );
                ?>
                      
                <?php 
                    echo CHtml::link(
                        'Удалить', 
                        array('admin/user/delete', 'id' => $model->id),
                        array('class' => 'linkButton linkButton--default -azure -azure--action -jsItemDeleteConfirmation')
                    );
                ?>
            </div>
        </div>  
          
    </div>
</div>


