<?php 
    if ( ($row % 2) === 0) {
        // Название класса, для чередование цвета строк таблицы.
        $trClass = '-paleBlue'; 
    } else {
        $trClass = '';
    }
?>
<tr class="<?php echo $trClass; ?>">
    <td class="scheduleTable__groupName">
        <?php require '_groupName.php'; ?>
        <?php require '_rowInfoStore.php'; ?>
    </td>
    <td class="scheduleTable__specializationName">
        <?php require '_specializationName.php'; ?>
    </td>
    <?php if ($s->needDoctor) : ?>
        <td class="scheduleTable__doctorName">
            <?php echo DoctorViewConst::getDoctorTextView($d->firstname, $d->surname, $d->patronymic, $d->additional); ?>
        </td>
    <?php else : ?>
        <td class="scheduleTable__doctorName">
            &nbsp;
        </td>
    <?php endif; ?>
    <?php $columnsCount = count($dates); ?>
    <?php for ($col = 0; $col < $columnsCount; $col++) : ?>
        <?php 
            if ($s->needDoctor) {
                $idDoctor = $d->id;
            } else {
                $idDoctor = ScheduleController::ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR;  
            }
            
            $class = "scheduleTable__cellPosition_".$row."_".$col;
            $class .= " date_".$col."_specialization_".$s->id."_doctor_".$idDoctor;
            $class .= " $selectableCellClass";
           
            // Есди есть данные об этом рабочем дне, то заполняем ими
            // Иначе считаем, что он(день) не был создан
            if (isset($workDays[$col][$s->id][$idDoctor]) ) {
                $idWorkDay = $workDays[$col][$s->id][$idDoctor]['id'];
                if ($workDays[$col][$s->id][$idDoctor]['published']) {
                    $state = ScheduleController::STATE_STORE_PUBLISHED_VALUE;
                    $stateView = ScheduleController::STATE_VIEW_PUBLISHED_VALUE;
                } else {
                    $state = ScheduleController::STATE_STORE_NOT_PUBLISHED_VALUE;;
                    $stateView = ScheduleController::STATE_VIEW_NOT_PUBLISHED_VALUE;
                }
            } else {
                $idWorkDay = ScheduleController::ID_WORK_DAY_STORE_NOT_CREATED_VALUE;
                $state = ScheduleController::STATE_STORE_NOT_CREATED_VALUE;
                $stateView = ScheduleController::STATE_VIEW_NOT_CREATED_VALUE;
            }
            
        ?>
        <td class="<?php echo $class; ?>">
            <span class="scheduleTable__cellStateView"><?php echo $stateView ?></span>
            <span class="scheduleTable__cellInfoStore -notVisible">
                <span class="scheduleTable__idWorkDayStore"><?php echo $idWorkDay?></span>
                <span class="scheduleTable__stateStore"><?php echo $state?></span>
                <span class="scheduleTable__dateNumberStore"><?php echo $col; ?></span>
                <span class="scheduleTable__rowStore"><?php echo $row;?></span>
                <span class="scheduleTable__colStore"><?php echo $col;?></span>
            </span>
        </td>
    <?php endfor; ?>
</tr>