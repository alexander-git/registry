<?php

/**
 * This is the model class for table "{{templateworkday}}".
 *
 * The followings are the available columns in table '{{templateworkday}}':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property TemplateWorkTime[] $time
 */

Yii::import('constant.validation.TemplateWorkDayConst');
Yii::import('helpers.TimeFormatHelper');

class TemplateWorkDay extends CActiveRecord
{
	
    public function tableName()
    {
        return '{{templateWorkDay}}';
    }
    
    public function rules()
    {
        return array(
            array('name', 'required', 'message' => TemplateWorkDayConst::NAME_REQUIERED_MSG),
            array(
                'name', 
                'length', 
                'min' => TemplateWorkDayConst::NAME_MIN_LENGTH, 
                'max' => TemplateWorkDayConst::NAME_MAX_LENGTH, 
                'tooShort' => TemplateWorkDayConst::NAME_TOO_SHORT_MSG,
                'tooLong' => TemplateWorkDayConst::NAME_TOO_LONG_MSG,
            ),
            array('name', 'unique', 'message' => TemplateWorkDayConst::NAME_IS_NOT_UNIQUE_MSG),
            array('name', 'match', 'pattern' => TemplateWorkDayConst::NAME_PATTERN, 'message' => TemplateWorkDayConst::NAME_IS_NOT_CORRECT_MSG),
        );
    }

    public function relations()
    {
        return array(
            'time' => array(self::HAS_MANY, 'TemplateWorkTime', 'idTemplateWorkDay'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'name' => 'Имя',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function deleteTimeById($id) {
        TemplateWorkTime::model()->deleteAllByAttributes(array('idTemplateWorkDay' => $id) );  
    }
    
    public function deleteTime() {
        self::deleteTimeById($this->id);
    }
    
    public static function updateTimeById($id, $time, $timeStates) {
        //Удаляем старое время
        self::deleteTimeById($id);
        
        //Создаём новое
        for ($i = 0; $i < count($time); $i++) {
            $templateWorkTime = new TemplateWorkTime();
            $templateWorkTime->idTemplateWorkDay = $id;
            $templateWorkTime->time = TimeFormatHelper::timeShortTextViewToTimeDBView($time[$i]);
            $templateWorkTime->state = $timeStates[$i];
            if (!$templateWorkTime->save() ) {
                throw new ModifyDBException();
            }  
        } 
    }   
    
    public function updateTime($time, $timeStates) {
        self::updateTimeById($this->id, $time, $timeStates);
    }
    
    
}
