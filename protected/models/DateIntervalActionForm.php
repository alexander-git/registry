<?php

Yii::import('constant.validation.DateIntervalActionFormConst');
Yii::import('helpers.DateFormatHelper');

class DateIntervalActionForm extends CFormModel
{
    public $dateBegin;
    public $dateEnd;
    
    public function rules()
    {
        return array(
            array('dateBegin', 'required', 'message' => DateIntervalActionFormConst::DATE_BEGIN_REQUIERED_MSG),
            array('dateEnd', 'required', 'message' => DateIntervalActionFormConst::DATE_END_REQUIERED_MSG),
            array('dateBegin', 'ext.validators.DateInCommonTextViewCorrect', 'message' => DateIntervalActionFormConst::DATE_BEGIN_IS_NOT_CORRECT_MSG),
            array('dateEnd', 'ext.validators.DateInCommonTextViewCorrect', 'message' => DateIntervalActionFormConst::DATE_END_IS_NOT_CORRECT_MSG),
            array('dateEnd', 'isDateBeginGreatherThenDateEnd'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'dateBegin' => 'с',
            'dateEnd' => 'по'
        );
    }

    public function isDateBeginGreatherThenDateEnd($attribute, $params)
    {
        if($this->hasErrors() )  { 
            return; 
        }
        
        $dateBeginValue = DateFormatHelper::getDateFromCommonTextView($this->dateBegin);
        $dateEndValue = DateFormatHelper::getDateFromCommonTextView($this->dateEnd);
        // Вычитает из $dateEndValue $dateBeginValue, т.е  $dateEndValue - $dateBeginValue
        $interval = $dateBeginValue->diff($dateEndValue);  
        $isPositiveOrEquals = $interval->format('%R') === "+";
        if (!$isPositiveOrEquals) {
           $this->addError($attribute,DateIntervalActionFormConst::DATE_BEGIN_GREATHER_THEN_DATE_END_MSG); 
        }
    }

}
