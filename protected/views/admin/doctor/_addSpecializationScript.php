<?php
 if (!isset($scriptName) ) {
     $scriptName = 'addSpecialization';
 }
 
$this->renderPartial('//include/_jquery-tmpl');
$this->renderPartial('//include/_removableItem');

$doctorSpecializationsTemplateId = 'doctorSpecializationTemplate';

Yii::app()->clientScript->registerScript(
   $scriptName,
    "
    var $jsEventListenerVarName = {};

    $(document).ready(function() {
    
        RemovableItem.prepareRemovableItems();

        var DOCTOR_SPECIALIZATION_TEMPLATE_SELECTOR = '#$doctorSpecializationsTemplateId'; 
       
        // Селекторы(конструктор) для храненния специализаций врача.
        var DoctorSpecializationsSelectors = function() {
            this.DOCTOR_SPECIALIZATIONS_FULL_SELECTOR = '.doctorSpecializations';
            this.ID_SPECIALIZATION_SELECTOR = '.doctorSpecializations__idSpecialization';
        };
        
        DocSpecSel = new DoctorSpecializationsSelectors();
        
        $($jsEventListenerVarName).on(SearchEvents.SELECT, function(e) {
            var id = e.value;
            var text = e.text;
            if (id == null) {
                return;
            } else {
                // Проверяем не добавленно ли было раньше элементов с таким id
                var inputs = $(DocSpecSel.DOCTOR_SPECIALIZATIONS_FULL_SELECTOR).find(DocSpecSel.ID_SPECIALIZATION_SELECTOR);
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].value == id) {
                        return; // такой элемент уже есть - ничего не добавляем
                    }
                }
                //Добавляем элемент
                var data = {
                    'id' : id,
                    'text' : text
                };
                $(DOCTOR_SPECIALIZATION_TEMPLATE_SELECTOR).tmpl(data).appendTo(DocSpecSel.DOCTOR_SPECIALIZATIONS_FULL_SELECTOR);
                return;
            }
        }); 
    });  
    ",
   CClientScript::POS_HEAD
);  
