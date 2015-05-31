<?php
// Если нужно использовать константы предназначенные для валидации модели Order
// в форме заказа в angular, то следует добавить(renderPartial) этот файл 
// в index.php. 
// Затем зарегистрировать константу в angular(app.constant() ), внедрить её в 
// контроллер связанный с формой оформления заказа. В контроллере с помощью
// значений из константы сформировать правила для валидации формы.

// Если не использовать этот файл и создавать правила валидации в angular 
// врчную, то нужно следить, чтобы правила в js-коде не противоречили правилам 
// валидации из модели - нарпример были бы менее жесткими. Особенно внимательным 
// в этом случае нужно быть с шаблоном телефона т.к. его можно менять в 
// настройках Например, в js-коде жестко задано, что он должен содержать только
// цифры. При этом если администратор задаст в шаблоне обязательными 
// другие символы, например '-', то пользователь вообще не сможет создать заявку
// т.к. в форме нельзя будет ввести телефон, который пройдёт валидацию в модели.
// Разуемеется, правила для максимальной длинны чего-либо можно сделать в js и 
// более жесткими чем в модели - валидация будет успешной и там и там. С другой
// стороны шаблон фамилии может пройти валидацию в js-коде, но не пройти 
// в модели т.к. там задано больше недопустимых символов. Это тоже нормально 
// т.к. возможности шаблонов в js ограничены. Главное, чтобы не было 
// противоречия. Также очевидно, что при использовании этих констант в js-коде
// не обязательно использовать их все.

Yii::import('constant.validation.OrderConst');
Yii::import('utils.ApplicationConfig');

$firstnameMinLength = OrderConst::FIRSTNAME_MIN_LENGTH;
$firstnameMaxLength = OrderConst::FIRSTNAME_MAX_LENGTH;

// Фамилия и отчество обязательными не являются, поэтому минимальной длинны 
// для них не задаётся.
$surnameMaxLength = OrderConst::SURNAME_MAX_LENGTH;
$patronymicMaxLength = OrderConst::PATRONIMYC_MAX_LENGTH;

// Шаблоны для имени, фамилии и отчества не передаём в js, т.к. там используется
// сравнение с unicode и валидация с помощью javascipt будет работать неправильно.
// Поэтому код закомментирован.
// $firstnamePattern = OrderConst::FIRSTNAME_PATTERN;
// $surnamePattern = OrderConst::SURNAME_PATTERN;
// $patronymicPattern = OrderConst::PATRONYMIC_PATTERN;

$phoneMinLength = OrderConst::PHONE_MIN_LENGTH;
$phoneMaxLength = OrderConst::PHONE_MAX_LENGTH;
// Шаблон для телефона, если он задан разумно, предполагает наличие только
// цифр и возможно некоторых символов вроде '-', поэтому его в js передаём.
$phonePattern = ApplicationConfig::getInstance()->getPhonePattern();


Yii::app()->clientScript->registerScript(
   'orderFormValidationConst',
    "      
    var orderFormValidationConst = {
        'FIRSTNAME_MIN_LENGTH' : $firstnameMinLength,
        'FIRSTNAME_MAX_LENGTH' : $firstnameMaxLength,

        'SURNAME_MAX_LENGTH' : $surnameMaxLength,
      
        'PATRONYMIC_MAX_LENGTH' : $patronymicMaxLength,
            
        'PHONE_MIN_LENGTH' : $phoneMinLength,
        'PHONE_MAX_LENGTH' : $phoneMaxLength,
        'PHONE_PATTERN' : '$phonePattern'
    };
    ",
   CClientScript::POS_HEAD
); 