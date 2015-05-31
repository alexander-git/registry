<?php 
if (!isset($generateJsTemplate) ) {
    throw new LogicException();
}
if (!$generateJsTemplate) {
    // Если это не заготовка для js-шаблона, а шаблон код 
    // выводимый php, то должны быть установленны $text и $id.
    if (!isset($text)  || !isset($id) ) {
        throw new LogicException();  
    }
}
    
if ($generateJsTemplate) {
    $doctorSpecializationTemplateId = 'doctorSpecializationTemplate';
    $text = '${text}';
    $id = '${id}';
} 

?>
<?php 
    // В случае $generateJsTemplate === false, когда шаблон используется для вывода 
    // уже существующих специализаций средствами php(а не js) 
    // при открытии формы изменения врача, обрамляющий div c id шаблона
    // выводиться не должен. Он используется только вместе jquery-templ  
    // для при добавлении специализаций динамически, а не при генерации страницы.
?>
<?php if ($generateJsTemplate) : ?>
    <div id="<?php echo $doctorSpecializationTemplateId; ?>" style="display : none;">
<?php endif; ?>
        <div class="removableItem">
                <span class="removableItem__info -azure -roundedCornersLeft"><?php echo $text; ?></span>
                <span class="removableItem__remove -darkAzure -darkAzure--action -roundedCornersRight">
                    <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/smallCross.gif"/>
                </span>
                <input class="doctorSpecializations__idSpecialization" type="hidden" name="specializations[]" value="<?php echo $id; ?>">
        </div>
<?php if ($generateJsTemplate) : ?>
    </div>
<?php endif; 