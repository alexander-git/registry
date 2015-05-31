<?php

// $valueContainerId - id input-а(обычно типа hidded) куда будет записано выбранное 
// c помощью диалога значение.
// $textFieldId - текстовое поле(обычно readonly) куда будет записан текст 
// ассоциированный с выбраным значением(именно из текстовых представлений и 
// выбирает пользователь в диалоге).

if (
    !isset($scriptName) ||
    !isset($dialogId) ||
    !isset($jsEventListenerVarName) ||
    !isset($valueContainerId) ||
    !isset($textFieldId) ||
    !isset($dialogOpenButtonId) ||
    !isset($clearButtonId) 
    )
{
    throw new LogicException();
}

  
Yii::app()->clientScript->registerScript(
   $scriptName,
    "
    
    // Переменная слушателя будет глобальной. Она же регистрируется 
    // в Search-диалоге, который при успешном выборе посылает ей сообщение.
    var $jsEventListenerVarName = {};

    $(document).ready(function() {
        var DIALOG_FULL_SELECTOR = '#$dialogId';
        var VALUE_CONTAINER_FULL_SELECTOR = '#$valueContainerId';
        var TEXT_FIELD_FULL_SELECTOR = '#$textFieldId'; 
        var DIALOG_OPEN_BUTTON_FULL_SELECTOR = '#$dialogOpenButtonId';
        var CLEAR_BUTTON_FULL_SELECTOR = '#$clearButtonId';

        $($jsEventListenerVarName).on(SearchEvents.SELECT, function(e) {
            var value = e.value;
            var text = e.text;
            if (value == null) {
                return; // Ничего не выбрано - состояние полей не меняем.
            } else {
                $(VALUE_CONTAINER_FULL_SELECTOR).val(value);
                $(TEXT_FIELD_FULL_SELECTOR).val(text);
            }
        }); 
        
        $(DIALOG_OPEN_BUTTON_FULL_SELECTOR).on('click', function() {
            $(DIALOG_FULL_SELECTOR).dialog('open'); 
            return false;
        });

        // Щелчёк на кнопке удаления из текстового и скрытого полей.
        $(CLEAR_BUTTON_FULL_SELECTOR).on('click', function() {
            $(VALUE_CONTAINER_FULL_SELECTOR).val('');
            $(TEXT_FIELD_FULL_SELECTOR).val('');
        });
    });  
    ",
   CClientScript::POS_HEAD
);