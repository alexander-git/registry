<?php
    Yii::import('constant.view.OrderViewConst');

    $processedArrayForDropDownList = array(
        'all' => 'Любая',
        'true' => 'Обработанные',
        'false' => 'Необработанные'
    );

    $statesArrayForDropDownList = array_merge(
        array('all' => 'Любое'),
        OrderViewConst::getStateArrayForSelectTag()
    );
?>
<?php 
    // filterOrderItems  исподьзуются только в js - для создания селекторов
    // и выбора данных из списков и т.д. 
?>
<div class="filterOrderItems -defaultInputItemsFont" id="<?php echo $id; ?>">
    Категория
    <span class="selectWrapper">
        <?php 
            echo CHtml::dropDownList(
                'processed',
                null,
                $processedArrayForDropDownList,
                array(
                    'class' => 'filterOrderItems__processed inputItem',
                    'autocomplete' => 'off'                        
                )
            ); 
        ?>
    </span>
    Состояние
    <span class="selectWrapper">
        <?php 
            echo CHtml::dropDownList(
                'state', 
                null, 
                $statesArrayForDropDownList, 
                array(
                    'class' => 'filterOrderItems__state inputItem',
                    'autocomplete' => 'off' 
                )
            );
        ?>
    </span>
</div>