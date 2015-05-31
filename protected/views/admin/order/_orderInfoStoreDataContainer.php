<?php
Yii::import('constant.view.SpecializationViewConst');
Yii::import('constant.view.DoctorViewConst');
Yii::import('helpers.DateFormatHelper');

$ID_DOCTOR_TEXT_VALUE_WHEN_ID_DOCTOR_IS_NULL = 'null';
?>
<span class="orderInfoStore__dataContainer">
    <span class="orderInfoStore__date"><?php echo CHtml::encode(DateFormatHelper::dateDBViewToDateCommonTextView($order->date) ); ?></span>
    <span class="orderInfoStore__idSpecialization"><?php echo $order->idSpecialization; ?></span>
    <?php 
        $specializationName = SpecializationViewConst::getSpecializationTextView(
            $order->specialization->name, 
            $order->specialization->additional
        );
    ?>
    <span class="orderInfoStore__specializationName"><?php echo $specializationName; ?></span>
    <?php if ($order->idDoctor !== null) : ?>
        <?php 
            $idDoctor = $order->idDoctor;
            $doctorName = DoctorViewConst::getDoctorTextView(
                $order->doctor->firstname, 
                $order->doctor->surname,
                $order->doctor->patronymic,
                $order->doctor->additional
            ); 
        ?>
        <span class="orderInfoStore__idDoctor"><?php echo $idDoctor; ?></span>
        <span class="orderInfoStore__doctorName"><?php echo $doctorName; ?></span>
    <?php else : ?> 
         <span class="orderInfoStore__idDoctor"><?php echo $ID_DOCTOR_TEXT_VALUE_WHEN_ID_DOCTOR_IS_NULL; ?></span>
    <?php endif; ?>
</span>
