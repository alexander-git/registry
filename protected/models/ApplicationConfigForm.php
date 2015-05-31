<?php

Yii::import('constant.validation.ApplicationConfigFormConst');


class ApplicationConfigForm extends CFormModel
{
    public $timeZone;
    public $startingOffsetInDaysOfScheduleForVisitors;
    public $makeTimeBusyOnOrder;
    public $phonePattern;
    
    public function rules()
    {
        return array(
            array('timeZone', 'required', 'message' => ApplicationConfigFormConst::TIME_ZONE_REQUIERED_MSG),
            array(
                'timeZone', 
                'length', 
                'min' => ApplicationConfigFormConst::TIME_ZONE_MIN_LENGTH, 
                'max' => ApplicationConfigFormConst::TIME_ZONE_MAX_LENGTH, 
                'tooShort' => ApplicationConfigFormConst::TIME_ZONE_TOO_SHORT_MSG,
                'tooLong' => ApplicationConfigFormConst::TIME_ZONE_TOO_LONG_MSG,
            ),
            
            array(
                'startingOffsetInDaysOfScheduleForVisitors', 
                'required', 
                'message' =>  ApplicationConfigFormConst::STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_REQUIERED_MSG
            ),
            array(
                'startingOffsetInDaysOfScheduleForVisitors', 
                'numerical',
                'integerOnly' => true,
                'message' => ApplicationConfigFormConst::STARTING_OFFSET_IN_DAYS_OF_SCHEDULE_FOR_VISITORS_IS_NOT_CORRECT_MSG
            ),
            
            array(
                'phonePattern',
                'safe', 
            ),
            
            array(
                'makeTimeBusyOnOrder', 
                'required', 
                'message' => ApplicationConfigFormConst::MAKE_TIME_BUSY_ON_OREDR_REQUIERED_MSG
            ),
            array(
                'makeTimeBusyOnOrder',
                'boolean', 
                'message' => ApplicationConfigFormConst::MAKE_TIME_BUSY_ON_OREDR_IS_NOT_CORRECT_MSG
            ), 
           
        );
    }

    public function attributeLabels()
    {
        return array(
            'timeZone' => 'Временная зона',
            'startingOffsetInDaysOfScheduleForVisitors' => 'Cмещение расписания(в днях)',
            'makeTimeBusyOnOrder' => 'Делать время занятым при заявке пользователя',
            'phonePattern' => 'Формат телефона в заявке'
        );
    }

}
