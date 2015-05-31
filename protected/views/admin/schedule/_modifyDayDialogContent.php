<div class="workDay -blue -marginTop10 -defaultInputItemsFont">
    <div class="workDay__generalInfo">
        <div>
            Дата : <span class="workDay__date"></span>
        </div>
        <div>
            Специализаиця : <span class="workDay__specializationName"></span> 
        </div>
        <div class="workDay__doctorInfo">
            Врач : <span class="workDay__doctorName"></span>
        </div>
    </div>
   
    <div class="workDay__dayIsNotExistsMessage -notVisible">
        День не создан
    </div>
   
    <br />
    <div class="timeEditor">
         <div class="timeEditor__timeItemTemplate -notVisible">
            <div class="timeEditor__timeItem -roundedCorners">${time}</div>
        </div>
        <div class="timeEditor__inputPanel">
            <div>
                Интервал
                с
                <?php
                    $this->widget('CMaskedTextField', 
                        array(
                            'skin' => 'timeHoursMinutes',
                            'name' => 'timeBegin',
                            'htmlOptions' => array(
                                'class' => 'timeEditor__intervalBegin inputItem',
                                'style' => '',
                                'autocomplete' => 'off',
                                'size' => '5',
                            ),                    
                        )
                    );
                ?>
                до
                <?php
                    $this->widget('CMaskedTextField', 
                        array(
                            'skin' => 'timeHoursMinutes',
                            'name' => 'timeEnd',
                            'htmlOptions' => array(
                                'class' => 'timeEditor__intervalEnd inputItem',
                                'style' => '',
                                'autocomplete' => 'off',
                                'size' => '5',
                            ),                    
                        )
                    );
                ?>
                по
                <?php
                    echo CHtml::textField(
                        'duration', 
                        '0',
                        array(
                            'class' => 'timeEditor__intervalDuration inputItem',
                            'style' => '',
                            'autocomplete' => 'off',
                            'size' => '4',
                            'maxlength' => '4',
                        )                  
                    );
                ?>
                мин.
                <?php
                    echo CHtml::button(
                        'Добавить', 
                        array('class' => 'timeEditor__addIntervalButton inputItem -darkAzure -darkAzure--action')
                    );
                ?>
            </div>
            <div class="-marginTop20">
                    Время
                    <?php
                        $this->widget('CMaskedTextField', 
                            array(
                                'skin' => 'timeHoursMinutes',
                                'name' => 'singleTime',
                                'htmlOptions' => array(
                                    'class' => 'timeEditor__singleTime inputItem',
                                    'style' => 'margin-right : 5px',
                                    'autocomplete' => 'off',
                                    'size' => '5',
                                ),                    
                            )
                        );
                    ?>
                     <?php
                        echo CHtml::button(
                            'Добавить', 
                            array('class' => 'timeEditor__addSingleTimeButton inputItem -darkAzure -darkAzure--action')
                        );
                    ?>

            </div>
            <div class="timeEditor__inputErrorMessage -errorMessage -marginTop10 -hidden" style="width : 600px;">hidden</div>
        </div>

        <div class="timeEditor__timePanel -marginTop10"> 
            <div class="timeEditor__time  -roundedCorners">    
                <div class="-stopFloat"></div>
            </div>
 
            <div class="timeEditor__timeInstruments timeEditor__timeInstruments--decorateButtons -roundedCorners ">
                <div class="-useGrayBlueSpans -useGrayBlueSpans--activeDecoration">
                    <div class="-table">
                        <div class="-tableRow">
                            <div class="-centerTableCellV">
                                <span class="timeEditor__normalModeButton" title="Обычный режим работы курсора">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="-table">
                        <div class="-tableRow">
                            <div class="-centerTableCellV">
                                <span class="timeEditor__freeButton" title="Свободно">
                                    <div class="timeEditor__buttonColor -timeEditor--timeFree"></div>
                                </span>
                            </div>
                            <div class="timeEditor__buttonCaption -centerTableCellV">
                                - свободно
                            </div>
                        </div>
                    </div>

                    <div class="-table">
                        <div class="-tableRow">
                            <div class="-centerTableCellV">
                                 <span class="timeEditor__busyButton" title="Занято">
                                     <div class="timeEditor__buttonColor -timeEditor--timeBusy"></div>
                                 </span> 
                            </div>
                            <div class="timeEditor__buttonCaption -centerTableCellV">
                                - занято
                            </div>
                        </div>
                    </div>

                    <div class="-table">
                        <div class="-tableRow">
                            <div class="-centerTableCellV">
                                <span class="timeEditor__recordImpossibleButton" title="Запись через интернет невозможна">
                                    <div class="timeEditor__buttonColor -timeEditor--recordImpossible"></div>
                                </span>
                            </div>
                            <div class="timeEditor__buttonCaption -centerTableCellV">
                                - запись через интернет  невозможна
                            </div>
                        </div>
                    </div>

                    <div class="-table">
                        <div class="-tableRow">
                            <div class="-centerTableCellV">
                                <span class="timeEditor__deleteButton" title="Удалить">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-stopFloat"></div>
        </div>
    </div>
    
    <div class="-marginTop10"> 
        Опубликовать : 
        <?php
            echo CHtml::checkBox(
                'workDay__published', 
                false, 
                array('class' => 'workDay__published inputItem')
            );
        ?>
    </div>
    
    <div class="-marginTop20">
        <div class="workDay__previousButton -floatLeft">
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/leftButton.gif">
        </div>
        <div class="workDay__nextButton -floatRight">
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/rightButton.gif">
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    
    <div class="workDay__process -centerTextH -marginTop10 -notVisible">
        <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
    </div>
    <div class="workDay__infoMessage -centerTextH -marginTop10 -notVisible">
        Изменение успешно
    </div>
    <div class="workDay__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
        Произошла ошибка
    </div>
    
    <div class="-line2 -darkAzure -marginTop10"></div>
    <div class="dialogButtonPanel -marginTop10">
        <?php
            echo CHtml::button(
                'Применить', 
                array('class' => 'workDay__performButton inputItem -darkAzure -darkAzure--action')
            );
        ?>
        <?php
            echo CHtml::button(
                'Выйти', 
                array('class' => 'workDay__quitButton inputItem -darkAzure -darkAzure--action')
            );
        ?>
    </div>

</div>
