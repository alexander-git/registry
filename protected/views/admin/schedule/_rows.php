<?php 
    Yii::import('constant.view.GroupViewConst');
    Yii::import('constant.view.SpecializationViewConst');
    Yii::import('constant.view.DoctorViewConst');

    $row  = 0;
    $lastGroupName = null; 
    $selectableCellClass = 'sheduleTable__selectableCell';
?>
<?php foreach($groups as $g) : ?>
    <?php foreach($g->specializations as $s) : ?>
        <?php $lastSpecializationName = null; ?>
        <?php if ( (!$s->needDoctor) ) : ?>
            <?php require '_row.php'; ?>
            <?php ++$row; ?>
        <?php else : ?>
            <?php foreach($s->doctors as $d) : ?>
                <?php require '_row.php'; ?>
                <?php ++$row; ?>
            <?php endforeach ?>
        <?php endif; ?>
    <?php endforeach ?>
<?php endforeach; 