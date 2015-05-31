<?php
/* @var $this ManageController */

require_once '_defineMainMenu.php';
require_once '_defineManageMenu.php';
$this->makeMenuItemActiveOnUrl($this->manageMenu, 'adminActions');

$this->additionalLayout = 'adminManage';
$this->pageTitle = 'Операции';

$this->renderPartial('//include/_adminActions');

$unstallUserRoles = $this->createUrl('/admin/manage/installUserRoles');
Yii::app()->clientScript->registerScript(
   'adminActions',
    "
    $(document).ready(function() {    
        var urls = {
            'installUserRoles' : '$unstallUserRoles'
        };
        
        var adminActions = new AdminActions(urls);
       
    });
    ",
   CClientScript::POS_HEAD
); 

?>

<div class="mainBlockHeader -roundedCornersTop -pear">
   Операции
</div>
<div class= "mainBlock -blue -roundedCornersBottom">
    <div class="adminActions -defaultInputItemsFont">
        <div class="-fontSize18">
            <div class="adminActions__process -centerTextH -notVisible">
                <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
            </div>
            <div class="adminActions__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
                Произошла ошибка
            </div>
            <div class="adminActions__successMessage -centerTextH -marginTop10 -notVisible"></div>
        </div>
        <div class="-marginTop20">
            <?php 
                echo CHtml::button(
                    'Установить права пользователей', 
                    array('class' => 'adminActions__installUserRoles -darkAzure -darkAzure--action inputItem') 
                ); 
            ?>
        </div>  
    </div>
</div>