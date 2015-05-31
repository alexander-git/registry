<div class="scheduleControlPanel__instuments -useGrayBlueSpans -useGrayBlueSpans--activeDecoration" valign="middle">
    <div class="scheduleControlPanel__groupButtons">
        <span class="scheduleControlPanel__normalModeButton" title="Обычный режим работы курсора"></span>
    </div>
    
    <div class="scheduleControlPanel__groupButtons">
        <span class="scheduleControlPanel__cellSelectDeselectButton" title="Выделение ячейки"></span>
        <span class="scheduleControlPanel__areaSelectButton" title="Выделение области"></span>
        <span class="scheduleControlPanel__areaDeselectButton" title="Снять выделение с области"></span>
        <span class="scheduleControlPanel__completelyDeselectButton" title="Снять выделение полностью"></span>
    </div>
    
    <div class="scheduleControlPanel__groupButtons">
        <span class="scheduleControlPanel__safeUpdateDayButton" title="Изменить время в рассписании одного дня"></span>
        <span class="scheduleControlPanel__createUpdateDayButton" title="Создать/изменить рассписание одного дня"></span>
        <span class="scheduleControlPanel__deleteDayButton" title="Удалить расписание одного дня"></span>
        <span class="scheduleControlPanel__publishDepublishDayButton" title="Опубликовать/скрыть день"></span>
    </div> 
    
    <div class="scheduleControlPanel__groupButtons"> 
        <span class="scheduleControlPanel__viewTemplateWorkDayButton" title="Просмотр шаблона"></span>
        <?php 
            echo CHtml::textField(
                '', 
                '', 
                array(
                    'class' => 'scheduleControlPanel__selectTemplateWorkDayInput inputItem', 
                    'readonly' => 'readonly',
                    'autocomplete' => 'off',
                    'size' => 25
                ) 
            );
        ?>
        <span class="scheduleControlPanel__selectTemplateWorkDayButton" title="Выбрать шаблон"></span>
        <span class="scheduleControlPanel__clearTemplateWorkDayButton" title="Очистить"></span>
 
        <div class="-stopFloat"></div>
    </div>
    
    <div class="scheduleControlPanel__groupButtons"> 
        <span class="scheduleControlPanel__deleteSelectedButton" title="Удалить выделенное"></span>
        <span class="scheduleControlPanel__publishSelectedButton" title="Опубликовать выделенное"></span>
        <span class="scheduleControlPanel__depublishSelectedButton" title="Снять публикацию с выделенного"></span>
        <span class="scheduleControlPanel__acceptTemplateWorkDayToSelectedButton" title="Применить шаблон к выделенному"></span>
    </div>

    
    <div class="-stopFloat"></div>
</div>
