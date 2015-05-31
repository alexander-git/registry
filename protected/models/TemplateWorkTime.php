<?php

/**
 * This is the model class for table "{{templateworktime}}".
 *
 * The followings are the available columns in table '{{templateworktime}}':
 * @property integer $id
 * @property string $time
 * @property string $state
 * @property integer $idTemplateWorkDay
 *
 * The followings are the available model relations:
 * @property TemplateWorkDay $templateWorkDay
 */

Yii::import('constant.validation.TemplateWorkTimeConst');

class TemplateWorkTime extends CActiveRecord
{
	
    public function tableName()
    {
        return '{{templateWorkTime}}';
    }

    public function rules()
    {
      return array(
            array('time', 'required', 'message' => TemplateWorkTimeConst::TIME_REQUIERED_MSG),
            array(
                'time', 
                'match', 
                'pattern' => TemplateWorkTimeConst::TIME_PATTERN, 
                'message' => TemplateWorkTimeConst::TIME_IS_NOT_CORRECT_MSG
            ),
            
            array('state', 'required', 'message' => TemplateWorkTimeConst::STATE_REQUIRED_MSG),
            array(
                'state', 
                'in', 
                'range' => array(
                    WorkTime::STATE_FREE,
                    WorkTime::STATE_BUSY,
                    WorkTime::STATE_RECORD_IMPOSSIBLE
                ),
                'allowEmpty' => false, 
                'message' => TemplateWorkTimeConst::STATE_IS_NOT_CORRECT_MSG 
            ),
            
            array('idTemplateWorkDay', 'required', 'message' => TemplateWorkTimeConst::ID_TEMPLATE_WORK_DAY_REQUIERED_MSG),
            array(
                'idTemplateWorkDay', 
                'numerical',
                'integerOnly' => true,
                'allowEmpty' => false,
                'message' => TemplateWorkTimeConst::ID_TEMPLATE_WORK_DAY_IS_NOT_CORRECT_MSG
            ),
            array(
               'idTemplateWorkDay',
               'exist',
               'allowEmpty' => false,
               'attributeName' => 'id',
               'className' => 'TemplateWorkDay',
               'message' => TemplateWorkTimeConst::ID_TEMPLATE_WORK_DAY_IS_NOT_EXIST_MSG
            ),
        );
    }

	
    public function relations()
    {
        return array(
            'templateWorkDay' => array(self::BELONGS_TO, 'Templateworkday', 'idTemplateWorkDay'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'time' => 'Время ',
            'state' => 'Состояние',
            'idTemplateWorkDay' => 'Шаблон',
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
}
