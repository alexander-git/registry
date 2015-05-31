<div class="search search--usingSelectAsResult search--default -blue -marginTop10 -defaultInputItemsFont">
    <div class="search__inputPanel">
        <div class="inputItemsRow inputItemsRow--defaultLayout">
            <?php 
                    echo CHtml::textField(
                        'textToSearch', 
                        '', 
                        array(
                            'class' => 'search__textToSearch inputItem',
                            'style' => 'width : 200px;',
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
    <div class="search__process -centerTextH -marginTop10 -notVisible">
        <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
    </div>
    <div class="search__nothingIsFound -centerTextH -marginTop10 -notVisible">
        Ничего не найдено
    </div>
    <div class="search__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
        Произошла ошибка
    </div>
    <div class="search__resultPanel -notVisible -marginTop10">
        <div class="blockSelectWrapper">
            <select  class="search__result inputItem" size="6">
            </select>
        </div>
    </div>
    
    <div class="-line2 -darkAzure -marginTop10"></div>
    <div class="dialogButtonPanel -marginTop10">
        <?php
            echo CHtml::button(
                'Выбрать', 
                array('class' => 'search__selectButton inputItem -darkAzure -darkAzure--action')
            );
        ?>
        <?php
            echo CHtml::button(
                'Выйти', 
                array('class' => 'search__quitButton inputItem -darkAzure -darkAzure--action')
            );
        ?>
    </div>
</div>