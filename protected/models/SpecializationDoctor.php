<?php

/**
 * This is the model class for table "{{specialization_doctor}}".
 *
 * The followings are the available columns in table '{{specialization_doctor}}':
 * @property integer $idSpecialization
 * @property integer $idDoctor
 */

Yii::import('constant.validation.SpecializationDoctorConst');

class SpecializationDoctor extends CActiveRecord
{
    public function tableName()
    {
        return '{{specializationDoctor}}';
    }


    public function rules()
    {
        return array(
            array('idSpecialization',  'required', 'message' => SpecializationDoctorConst::ID_SPECIALIZATION_REQUIRED_MSG),
            array(
                'idSpecialization', 
                'numerical',
                'integerOnly' => true,
                'message' => SpecializationDoctorConst::ID_SPECIALIZATION_IS_NOT_CORRECT_MSG
            ),
            array(
               'idSpecialization',
               'exist',
               'allowEmpty' => false,
               'attributeName' => 'id',
               'className' => 'Specialization',
               'message' => SpecializationDoctorConst::ID_SPECIALIZATION_IS_NOT_EXIST_MSG
            ),
            
            array('idDoctor',  'required', 'message' => SpecializationDoctorConst::ID_DOCTOR_REQUIRED_MSG),
            array(
                'idDoctor', 
                'numerical',
                'integerOnly' => true,
                'message' => SpecializationDoctorConst::ID_DOCTOR_IS_NOT_CORRECT_MSG
            ),
            array(
               'idDoctor',
               'exist',
               'allowEmpty' => false,
               'attributeName' => 'id',
               'className' => 'Doctor',
               'message' => SpecializationDoctorConst::ID_DOCTOR_IS_NOT_EXIST_MSG
            ),
        );
    }

	
    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            'idSpecialization' => 'Id Специализации',
            'idDoctor' => 'Id Врача',
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
