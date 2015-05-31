<?php

/**
 * This is the model class for table "{{doctor}}".
 *
 * The followings are the available columns in table '{{doctor}}':
 * @property integer $id
 * @property string $firstname
 * @property string $surname
 * @property string $patronymic
 * @property string $additional
 * @property integer $enabled
 * @property string $speciality
 * @property string $info
 *
 * The followings are the available model relations:
 * @property Specialization[] $specializations
 */

Yii::import('constant.validation.DoctorConst');

class Doctor extends CActiveRecord
{
	
    public function tableName()
    {
        return '{{doctor}}';
    }

    public function rules()
    {
        return array(
            //array('firstname', 'required', 'message' => DoctorConst::FIRSTNAME_REQUIERED_MSG),
            array(
                'firstname',
                'length',
                'min' => DoctorConst::FIRSTNAME_MIN_LENGTH,
                'max' => DoctorConst::FIRSTNAME_MAX_LENGTH,
                'tooShort' => DoctorConst::FIRSTNAME_TOO_SHORT_MSG,
                'tooLong' => DoctorConst::FIRSTNAME_TOO_LONG_MSG
            ),
            array('firstname', 'match', 'pattern' => DoctorConst::FIRSTNAME_PATTERN, 'message' => DoctorConst::FIRSTNAME_IS_NOT_CORRECT_MSG),

            
            array('surname', 'required', 'message' => DoctorConst::SURNAME_REQUIERED_MSG),
            array(
                'surname',
                'length',
                'max' => DoctorConst::SURNAME_MAX_LENGTH,
                'tooLong' => DoctorConst::SURNAME_TOO_LONG_MSG
            ),
            array('surname', 'match', 'pattern' => DoctorConst::SURNAME_PATTERN, 'message' => DoctorConst::SURNAME_IS_NOT_CORRECT_MSG),

            array(
                'patronymic',
                'length',
                'max' => DoctorConst::PATRONIMYC_MAX_LENGTH,
                'tooLong' => DoctorConst::PATRONYMIC_TOO_LONG_MSG
            ),
            array('patronymic', 'match', 'pattern' => DoctorConst::PATRONYMIC_PATTERN, 'message' => DoctorConst::PATRONYMIC_IS_NOT_CORRECT_MSG),
            
            array(
                'additional', 
                'length',
                'max' => DoctorConst::ADDITIONAL_MAX_LENGTH,
                'tooLong' => DoctorConst::ADDITIONAL_TOO_LONG_MSG,
            ),
            
            /*
            array(
                'additional', 
                'ext.validators.CompositeUnique',
                'compareWithEmptyStrings' => true,
                'keyColumns' => array('firstname', 'surname', 'patronymic', 'additional'),
                'message' => DoctorConst::FIRSTNAME_SURNAME_PATRONYMIC_ADDITIONAL_IS_NOT_UNIQUE_MSG,
            ), 
            */
            
            array('enabled', 'required', 'message' => DoctorConst::ENABLED_REQUIERED_MSG),
            array('enabled', 'boolean', 'message' => DoctorConst::ENABLED_IS_NOT_CORRECT_MSG),
            
            array('speciality', 'required', 'message' => DoctorConst::SPECIALITY_REQUIRED_MSG),
            array(
                'speciality',
                'length',
                'min' => DoctorConst::SPECIALITY_MIN_LENGTH,
                'max' => DoctorConst::SPECIALITY_MAX_LENGTH,
                'tooShort' => DoctorConst::SPECIALITY_TOO_SHORT_MSG,
                'tooLong' => DoctorConst::SPECIALITY_TOO_LONG_MSG
            ),
            array('speciality', 'match', 'pattern' => DoctorConst::SPECIALITY_PATTERN, 'message' => DoctorConst::SPECIALITY_IS_NOT_CORRECT_MSG),  
           
            array(
                'info',
                'length',
                'max' => DoctorConst::INFO_MAX_LENGTH,
                'tooLong' => DoctorConst::INFO_TOO_LONG_MSG
            ), 
            
        );
    }

	
    public function relations()
    {
        return array(
            'specializations' => array(
                self::MANY_MANY, 
                'Specialization', 
                '{{specializationDoctor}}(idDoctor, idSpecialization)'
            )
        );
    }
    
    
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'firstname' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'additional' => 'Дополнительно',
            'enabled' => 'Включён',
            'speciality' => 'Специальность',
            'info' => 'Информация',
        );
    }
        
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    // Удаляет привязку специализаций к врачу
    public static function deleteSpecializationsById($idDoctor) {
        SpecializationDoctor::model()->deleteAllByAttributes(array('idDoctor' => $idDoctor) );  
    }
    
    // Удаляет привязку специализаций к врачу
    public function deleteSpecializations() {
        self::deleteSpecializationsById($this->id); 
    }
    
    public static function updateSpecializationsById($idDoctor, $idsSpecialization) {
         // Удаляем старые привязки специализаций, если они были
        self::deleteSpecializationsById($idDoctor);  
            
        // Привязываем специалиазии к врачу
        foreach ($idsSpecialization as $idSpecialization) {
           $sdModel = new SpecializationDoctor();
           $sdModel->idDoctor = $idDoctor;
           $sdModel->idSpecialization = $idSpecialization;
           if (!$sdModel->save() ) {
               throw new ModifyDBException();
           }
        }     
    }
    
    public function updateSpecializations($idsSpecialization) {
       self::updateSpecializationsById($this->id, $idsSpecialization);
    }
    
    
}
