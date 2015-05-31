<div class="timeEditor -defaultInputItemsFont">
    <div class="timeEditor__timeItemTemplate -notVisible">
        <div class="timeEditor__timeItem -roundedCorners">${time}</div>
    </div>
    <div class="timeEditor__inputPanel">
        <div class="twoColumns__row">
            <div class="twoColumns__left">
                Интервал с 
            </div>
            <div class="twoColumns__right">
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
        </div>
        <div class="twoColumns__row -marginTop15">
            <div class="twoColumns__left">
                Время 
            </div>
            <div class="twoColumns__right">
                <?php
                    $this->widget('CMaskedTextField', 
                        array(
                            'skin' => 'timeHoursMinutes',
                            'name' => 'singeTime',
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
                <div class="timeEditor__inputErrorMessage  -errorMessage -marginTop10 -notVisible -hidden">hidden</div>
            </div>
        </div>
    </div>
    
    <div class="twoColumns__row">
        <div class="twoColumns__left">
            <div class="-hidden">hidden</div> 
        </div>
        <div class="twoColumns__right">
            <div class="timeEditor__timePanel -marginTop20"> 
                <div class="timeEditor__time  -roundedCorners">    
                    <div class="-stopFloat"></div>
                </div>
                <div class="timeEditor__timeInstruments timeEditor__timeInstruments--decorateButtons -roundedCorners ">
                    <div class="-useGrayBlueSpans -useGrayBlueSpans--activeDecoration">
                        <div>
                            <span class="timeEditor__normalModeButton" title="Обычный режим работы курсора">
                            </span>
                        </div>

                        <div>
                            <span class="timeEditor__freeButton" title="Свободно">
                                <div class="timeEditor__buttonColor -timeEditor--timeFree"></div>
                            </span>
                        </div>

                        <div>
                            <span class="timeEditor__busyButton" title="Занято">
                                <div class="timeEditor__buttonColor -timeEditor--timeBusy"></div>
                            </span> 
                        </div>

                        <div>
                            <span class="timeEditor__recordImpossibleButton" title="Запись через интернет невозможна">
                                <div class="timeEditor__buttonColor -timeEditor--recordImpossible"></div>
                            </span>
                        </div>

                        <div>
                            <span class="timeEditor__deleteButton" title="Удалить">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="-stopFloat"></div> 
            </div>
        </div>
    </div>
</div>
