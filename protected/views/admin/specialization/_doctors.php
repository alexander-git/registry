<div class="viewAdditionalContainer -cyan -cyan--linkDecoration"> 
    <?php foreach($doctors as $d) :?>
        <?php 
            Yii::import('constant.view.DoctorViewConst');
            $linkText = DoctorViewConst::getDoctorTextView($d->firstname, $d->surname, $d->patronymic, $d->additional);
        ?>
        <?php 
            echo CHtml::link(
                CHtml::encode($linkText), 
                array('admin/doctor/view', 'id' => $d->id), 
                array('class' => 'link')
            );
        ?>
        <br />
    <?php endforeach; ?> 
</div>


