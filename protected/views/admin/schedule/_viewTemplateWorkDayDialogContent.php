<div class="templateWorkDay -blue -marginTop10 -defaultInputItemsFont">
    <div class="templateWorkDay__generalInfo">
        <div>
            Имя : <span class="templateWorkDay__templateName"></span>
        </div>
    </div>
   
    <div class="templateWorkDay__templateIsNotExistsMessage -centerTextH -marginTop20 -notVisible">
        Шаблон не создан.
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
            <div class="timeEditor__timeInstruments -roundedCorners">
                <div class="-useGrayBlueSpans -useGrayBlueSpans--activeDecoration">
                    <div class="-table">
                        <div class="-tableRow">
                            <div class="-centerTableCellV">
                                <span title="Свободно">
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
                                 <span title="Занято">
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
                                <span title="Запись через интернет невозможна">
                                    <div class="timeEditor__buttonColor -timeEditor--recordImpossible"></div>
                                </span>
                            </div>
                            <div class="timeEditor__buttonCaption -centerTableCellV">
                                - запись через интернет  невозможна
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-stopFloat"></div>
        </div>
    </div>
       
    <div class="templateWorkDay__process -centerTextH -marginTop10 -notVisible">
        <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
    </div>
    <div class="templateWorkDay__infoMessage -centerTextH -marginTop10 -notVisible">
        Изменение успешно
    </div>
    <div class="templateWorkDay__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
        Произошла ошибка
    </div>
    
    <div class="-line2 -darkAzure -marginTop10"></div>
    <div class="dialogButtonPanel -marginTop10">
        <?php
            echo CHtml::button(
                'Выйти', 
                array('class' => 'templateWorkDay__quitButton inputItem -darkAzure -darkAzure--action')
            );
        ?>
    </div>

</div>
