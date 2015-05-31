<div class="layout__header -padding10" style="padding-top : 0px">
    <div class="-azure">
        <table class="adminHeader">
            <tr>
                <td class="adminHeader__caption">
                    <?php echo CHtml::link('Электронная регистратура', array('/') ); ?>
                </td>
                <td class="adminHeader__logout">
                    <?php echo CHtml::link('Выйти('.Yii::app()->user->name.')', array('/login/logout') ); ?>
                </td> 
            </tr>
        </table>
    </div>
    <div class="mainMenuContainer -blue -blue--hrefDecoration -roundedCornersBottom">
        <?php 
            $mainMenuItems = $this->mainMenu;
            $this->widget(
                'zii.widgets.CMenu',
                array(
                    'items'=> $mainMenuItems,
                     'htmlOptions'=>array(
                        'class'=>'mainMenuContainer__mainMenu -horizontalMenu'
                        ),
                    'activeCssClass' => 'active',
                    'activateItems' => true,
                    'itemCssClass' => '',
                )
            ); 
        ?>
        <div class="-stopFloat"></div>
    </div>
</div>