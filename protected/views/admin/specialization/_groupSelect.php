<?php
    // Если группа не выбрана, то в качестве id будет '', т.е. ''  
    // будет и у соответсвующего значения value тэга option, значит на сервер
    // это значение из формы отправлено не будет и в модели в качестве idGroup
    // будет задано значение по умолчанию, которое как раз и соответствует 
    // отсутствию группы.
    $groups =  CHtml::listData(
        array_merge(
            array(array('id' => '', 'name' =>'Нет') ),
            Group::model()->findAll()
        ),
        'id', 
        'name'
    );
    $maxListSize = 6;
    $listSize = min(count($groups), $maxListSize);

    echo $form->dropDownList(
        $model, 
        'idGroup',
        $groups,
        array(
            'size' => $listSize, 
            'class' => 'inputItem', 
            'options' => array(
                '' => array('selected' => 'selected')
            ),
        )
    ); 
?>