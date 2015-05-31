<div class="search search--usingSelectAsResult -defaultInputItemsFont">
    <div class="search__inputPanel">
        <div class="inputItemsRow inputItemsRow--defaultLayout">
            
            <?php 
                    echo CHtml::textField(
                        'textToSearch', 
                        '', 
                        array(
                            'class' => 'search__textToSearch inputItem',
                            'style' => 'width : 205px;',
                            'autocomplete' => 'off',
                        ) 
                    ); 
            ?>
            <?php 
                 echo CHtml::button(
                     'Поиск', 
                     array(
                         'class' => 'search__searchButton inputItem -darkAzure -darkAzure--action', 
                     ) 
                 ); 
             ?>

             <?php
                if (!isset($showAllButtonText) ) {
                    $showAllButtonText= 'Показать всё';  
                }
                echo CHtml::button(
                    $showAllButtonText, 
                    array(
                        'class' => 'search__showAllButton inputItem -darkAzure -darkAzure--action', 
                    ) 
                ); 
            ?>
        </div>
    </div>
    <div style="width : 410px;">
        <div class="search__process -centerTextH -marginTop10 -notVisible">
            <!--TODO# вынести в общее -->
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
        </div>
        <div class="search__nothingIsFound -centerTextH -marginTop10 -notVisible">
            Ничего не найдено
        </div>
        <div class="search__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
            Произошла ошибка
        </div>
    </div>
    <div class="search__resultPanel -marginTop20 -notVisible">
            <div class="blockSelectWrapper">
                 <select  class="search__result inputItem" size="6">
                </select>
            </div>
    </div>
</div>