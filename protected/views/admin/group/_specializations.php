<div class="viewAdditionalContainer -cyan -cyan--linkDecoration"> 
    <?php foreach($specializations as $s) :?>
        <?php 
            Yii::import('constant.view.SpecializationViewConst');
            $linkText = SpecializationViewConst::getSpecializationTextView($s->name, $s->additional);
        ?>
        <?php 
            echo CHtml::link(
                CHtml::encode($linkText), 
                array('admin/specialization/view', 'id' => $s->id), 
                array('class' => 'link')
            );
        ?>
        <br />
    <?php endforeach; ?> 
</div>


