<div class="safeWorkDay -blue -marginTop10 -defaultInputItemsFont">
    <div class="safeWorkDay__generalInfo">
        <div>
            Дата : <span class="safeWorkDay__date"></span>
        </div>
        <div>
            Специализаиця : <span class="safeWorkDay__specializationName"></span> 
        </div>
        <div class="safeWorkDay__doctorInfo">
            Врач : <span class="safeWorkDay__doctorName"></span>
        </div>
        <div class="safeWorkDay__publishedInfo">
            Опубликован : <span class="safeWorkDay__published"></span> 
        </div>
    </div>
   
    <div class="safeWorkDay__dayIsNotExistsMessage -centerTextH -marginTop20 -notVisible">
        День не создан
    </div>
    
    <br />
    <div class="timeEditor">
         <div class="timeEditor__timeItemTemplate -notVisible">
            <div class="timeEditor__timeItem -roundedCorners">${time}</div>
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

    <div class="safeWorkDay__process -centerTextH -marginTop10 -notVisible">
        <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
    </div>
    <div class="safeWorkDay__infoMessage -centerTextH -marginTop10 -notVisible">
        Изменение успешно
    </div>
    <div class="safeWorkDay__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
        Произошла ошибка
    </div>
    
    <div class="-line2 -darkAzure -marginTop10"></div>
    <div class="dialogButtonPanel -marginTop10">
        <?php
            echo CHtml::button(
                'Выйти', 
                array('class' => 'safeWorkDay__quitButton inputItem -darkAzure -darkAzure--action')
            );
        ?>
    </div>

</div>
