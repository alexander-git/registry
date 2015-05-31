<?php

/**
 * This is the model class for table "{{group}}".
 *
 * The followings are the available columns in table '{{group}}':
 * @property integer $id
 * @property string $name
 * @property integer $enabled
 *
 * The followings are the available model relations:
 * @property Specialization[] $specializations
 */

Yii::import('constant.validation.GroupConst');

class Group extends CActiveRecord
{
    public function tableName()
    {
        return '{{group}}';
    }

    public function rules()
    {
        return array(
            array('name', 'required' , 'message' => GroupConst::NAME_REQUIERED_MSG),
            array('name', 'unique', 'message' => GroupConst::NAME_IS_NOT_UNIQUE_MSG),
            array(
                'name', 
                'length', 
                'min' => GroupConst::NAME_MIN_LENGTH,
                'max' => GroupConst::NAME_MAX_LENGTH,
                'tooShort' => GroupConst::NAME_TOO_SHORT_MSG,
                'tooLong' => GroupConst::NAME_TOO_LONG_MSG
            ),
            array('name', 'match', 'pattern' => GroupConst::NAME_PATTERN, 'message' => GroupConst::NAME_IS_NOT_CORRECT_MSG),

            array('enabled', 'required', 'message' => GroupConst::ENABLED_REQUIERED_MSG),
            array('enabled', 'boolean', 'message' => GroupConst::ENABLED_IS_NOT_CORRECT_MSG),
        );
    }

    public function relations()
    {
        return array(
            'specializations' => array(self::HAS_MANY, 'Specialization', 'idGroup'),
            'specializationsCount' => array(
                self::STAT, 
                'Specialization', 
                'idGroup', 
                'select' => 'COUNT(*)',
                'defaultValue' => 0
            )
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'name' => 'Имя',
            'enabled' => 'Включена',
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
}
