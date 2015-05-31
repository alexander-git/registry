<?php

if (!isset($scriptName) ) {
    $scriptName = "updateList-$listId";
}

$this->renderPartial('//include/_jquery');
$this->renderPartial('//include/_Const');

$clientScript = Yii::app()->clientScript;

$clientScript->registerScript(
    $scriptName,
    "
        $(document).ready(function() {
            function updateList_$listId(){
                $.fn.yiiListView.update('$listId');
                return true;
            }

            $('#$listId .-jsListItemAjaxDeleteLink').live('click', function(e) {
                    if (confirm(Const.CONFIRM_QUESTION) ) {
                        var href = $(this).attr('href');
                        $.ajax({
                            'url' : href,
                            'type' : 'POST',
                            'success' : function(){ updateList_$listId(); },
                            'cache' : false
                         });
                    }

                    return false; 
              });
          });

    ",
    CClientScript::POS_HEAD
);