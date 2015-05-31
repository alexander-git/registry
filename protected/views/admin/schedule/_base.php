<div class= "mainBlock -roundedCornersBottom -blue">
    <?php if ($model === array() ) : ?>
        <div class="mainBlock__infoMessage">
            Отсутствуют необходимые данные для расписания.
        </div>
    <?php else : ?>
        <?php $this->renderPartial('_scheduleLoadingProcess'); ?>
        <?php $this->renderPartial('_scheduleErrorMessage'); ?>
        <?php $this->renderPartial('_datesStore', array('dates' => $dates) ); ?>
        <div class="-cyan -roundedCorners -margin10" style="margin-top : 0px;">
            <div class="-padding10">
                <div class="scheduleControlPanel">
                    <?php $this->renderPartial('_instruments'); ?>
                    <div class="-marginTop10">
                        <?php $this->renderPartial('_dateControl', array('dates' => $dates) ); ?>
                    </div>
                </div>
                <table class="scheduleTable -marginTop10">
                    <tr>
                        <th>Группа</th>
                        <th>Специализация</th>
                        <th>Врач</th>
                        <?php $this->renderPartial('_dateHeadCells', array('dates' => $dates)); ?>
                    </tr>
                    <?php 
                        $this->renderPartial(
                            '_rows', 
                            array(
                                'groups' => $model, 
                                'dates' => $dates,
                                'workDays' => $workDays,
                            ) 
                        ); 
                    ?>
                </table>
                <div class="-marginTop10">
                   <?php $this->renderPartial('_explanations'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $this->renderPartial('_modifyDayDialog'); ?>
<?php $this->renderPartial('_safeModifyDayDialog'); ?>
<?php $this->renderPartial('_selectTemplateWorkDayDialog'); ?>
<?php $this->renderPartial('_viewTemplateWorkDayDialog');
