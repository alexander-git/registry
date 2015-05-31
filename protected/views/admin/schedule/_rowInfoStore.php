<div class="scheduleTable__rowInfoStore -notVisible">
    <span class="scheduleTable__idSpecializationStore"><?php echo $s->id; ?></span>
    <span class="scheduleTable__specializationNameStore"><?php echo SpecializationViewConst::getSpecializationTextView($s->name, $s->additional); ?></span> 
    
    <?php if ($s->needDoctor) : ?>
        <span class="scheduleTable__idDoctorStore"><?php echo $d->id; ?></span>
        <span class="scheduleTable__doctorNameStore"><?php echo DoctorViewConst::getDoctorTextView($d->firstname, $d->surname, $d->patronymic, $d->additional); ?></span>
    <?php else : ?>
        <span class="scheduleTable__idDoctorStore"><?php echo ScheduleController::ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR; ?></span>
        <span class="scheduleTable__doctorNameStore"></span>
    <?php endif; ?>
</div>