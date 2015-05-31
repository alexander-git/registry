<?php

/**
 * This is the model class for table "{{specialization}}".
 *
 * The followings are the available columns in table '{{specialization}}':
 * @property integer $id
 * @property string $name
 * @property string $additional
 * @property integer $enabled
 * @property integer $needDoctor
 * @property integer $recordOnTime
 * @property integer $provisionalRecord
 * @property integer $idGroup
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property Doctor[] $doctors
 */


Yii::import('constant.validation.SpecializationConst');

class Specialization extends CActiveRecord
{

    public function tableName()
    {
        return '{{specialization}}';
    }

    public function rules()
    {
        return array(
            array('name', 'required', 'message' => SpecializationConst::NAME_REQUIERED_MSG),
            array(
                'name', 
                'length',
                'min' => SpecializationConst::NAME_MIN_LENGTH,
                'max' => SpecializationConst::NAME_MAX_LENGTH,
                'tooShort' => SpecializationConst::NAME_TOO_SHORT_MSG,
                'tooLong' => SpecializationConst::NAME_TOO_LONG_MSG
            ), 
            array('name', 'match', 'pattern' => SpecializationConst::NAME_PATTERN, 'message' => SpecializationConst::NAME_IS_NOT_CORRECT_MSG),
                
            array(
                'additional',
                'length',
                'max' => SpecializationConst::ADDTIONAL_MAX_LENGTH,
                'tooLong' => SpecializationConst::ADDITIONAL_TOO_LONG_MSG
            ),
            /*
            array(
                'additional', 
                'ext.validators.CompositeUnique',
                'keyColumns' => array('name', 'additional'),
                'message' => SpecializationConst::NAME_ADDITIONAL_IS_NOT_UNIQUE_MSG,
            ),
            */
            
            array('enabled', 'required', 'message' => SpecializationConst::ENABLED_REQUIERED_MSG),
            array('enabled', 'boolean', 'message' => SpecializationConst::ENABLED_IS_NOT_CORRECT_MSG),
            
            array('needDoctor', 'required', 'message' => SpecializationConst::NEED_DOCTOR_REQUIERED_MSG),
            array('needDoctor', 'boolean', 'message' => SpecializationConst::NEED_DOCTOR_IS_NOT_CORRECT_MSG),
            
            array('recordOnTime', 'required', 'message' => SpecializationConst::RECORD_ON_TIME_REQUIERED_MSG),
            array('recordOnTime', 'boolean', 'message' => SpecializationConst::RECORD_ON_TIME_IS_NOT_CORRECT_MSG),
            
            array('provisionalRecord', 'required', 'message' => SpecializationConst::PROVISIONAL_RECORD_REQUIERED_MSG),
            array('provisionalRecord', 'boolean', 'message' => SpecializationConst::PROVISIONAL_RECORD_IS_NOT_CORRECT_MSG),
            
            array(
                'idGroup', 
                'numerical',
                'integerOnly' => true,
                'message' => SpecializationConst::ID_GROUP_IS_NOT_CORRECT_MSG
            ),
           array(
               'idGroup',
               'exist',
               'allowEmpty' => true,
               'attributeName' => 'id',
               'className' => 'Group',
               'message' => SpecializationConst::ID_GROUP_IS_NOT_EXIST_MSG
            ),
        );
    }

    public function relations()
    {
        return array(
            'group' => array(
                self::BELONGS_TO, 
                'Group', 
                'idGroup'
            ),
            'doctors' => array(
                self::MANY_MANY, 
                'Doctor', 
                '{{specializationDoctor}}(idSpecialization, idDoctor)'
            ),
            'doctorsCount' => array(
                self::STAT,
                'Doctor',
                '{{specializationDoctor}}(idSpecialization, idDoctor)',
                'select' => 'COUNT(*)',
                'defaultValue' => 0
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'name' => 'Имя',
            'additional' => 'Дополнительно',
            'enabled' => 'Включена',
            'needDoctor' => 'Указывать врачей',
            'recordOnTime' => 'Запись на время',
            'provisionalRecord' => 'Предварительная запись',
            'idGroup' => 'id группы',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
}
