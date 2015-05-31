<?php

/**
 * This is the model class for table "{{worktime}}".
 *
 * The followings are the available columns in table '{{worktime}}':
 * @property integer $id
 * @property string $time
 * @property string $state
 * @property integer $idWorkDay
 *
 * The followings are the available model relations:
 * @property workdDay $idWorkDay
 */

Yii::import('constant.validation.WorkTimeConst');

class WorkTime extends CActiveRecord
{
    const STATE_FREE = 'free';
    const STATE_BUSY = 'busy';
    const STATE_RECORD_IMPOSSIBLE = 'recordImpossible';
    
    public function tableName()
    {
        return '{{workTime}}';
    }

    public function rules()
    {
        return array(
            
            array('time', 'required', 'message' => WorkTimeConst::TIME_REQUIERED_MSG),
            array(
                'time', 
                'match', 
                'pattern' => WorkTimeConst::TIME_PATTERN, 
                'message' => WorkTimeConst::TIME_IS_NOT_CORRECT_MSG
            ),
            
            array('state', 'required', 'message' => WorkTimeConst::STATE_REQUIRED_MSG),
            array(
                'state', 
                'in', 
                'range' => array(
                    self::STATE_FREE,
                    self::STATE_BUSY,
                    self::STATE_RECORD_IMPOSSIBLE
                ),
                'allowEmpty' => false, 
                'message' => WorkTimeConst::STATE_IS_NOT_CORRECT_MSG 
            ),
            
            array('idWorkDay', 'required', 'message' => WorkTimeConst::ID_WORK_DAY_REQUIERED_MSG),
            array(
                'idWorkDay', 
                'numerical',
                'integerOnly' => true,
                'allowEmpty' => false,
                'message' => WorkTimeConst::ID_WORK_DAY_IS_NOT_CORRECT_MSG
            ),
            array(
               'idWorkDay',
               'exist',
               'allowEmpty' => false,
               'attributeName' => 'id',
               'className' => 'WorkDay',
               'message' => WorkTimeConst::ID_WORK_DAY_IS_NOT_EXIST_MSG
            ),
        );    
    }

    public function relations()
    {
        return array(
            'workDay' => array(self::BELONGS_TO, 'Workday', 'idWorkDay'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'time' => 'Время',
            'state' => 'Состояние',
            'idWorkDay' => 'День',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
