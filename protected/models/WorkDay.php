<?php

/**
 * This is the model class for table "{{workday}}".
 *
 * The followings are the available columns in table '{{workday}}':
 * @property integer $id
 * @property string $date
 * @property integer $published
 * @property integer $idSpecialization
 * @property integer $idDoctor
 *
 * The followings are the available model relations:
 * @property Specialization $specialization
 * @property Doctor $doctor
 * @property Worktime[] $time
 */

Yii::import('constant.validation.WorkDayConst');
Yii::import('helpers.TimeFormatHelper');

class WorkDay extends CActiveRecord
{
    
    public function tableName()
    {
        return '{{workDay}}';
    }
    
    public function rules()
    {
        return array(
            array('date', 'required', 'message' => WorkDayConst::DATE_REQUIERED_MSG),
            array('date', 'match', 'pattern' => WorkDayConst::DATE_PATTERN, 'message' => WorkDayConst::DATE_IS_NOT_CORRECT_MSG),
            
            array('published', 'required', 'message' => WorkDayConst::PUBLISHED_REQUIERED_MSG),
            array('published', 'boolean', 'message' => WorkDayConst::PUBLISHED_IS_NOT_CORRECT_MSG),
            
            array('idSpecialization', 'required', 'message' => WorkDayConst::ID_SPECIALIZATION_REQUIERED_MSG),
            array(
                'idSpecialization', 
                'numerical',
                'integerOnly' => true,
                'message' => WorkDayConst::ID_SPECIALIZATION_IS_NOT_CORRECT_MESSAGE
            ),
            array(
                'idSpecialization',
                'exist',
                'allowEmpty' => false,
                'attributeName' => 'id',
                'className' => 'Specialization',
                'message' => WorkDayConst::ID_SPECIALIZATION_IS_NOT_EXIST_MSG
            ),
            
            array('idDoctor', 'checkRequiredDoctorForThisSpecialization'), // Берётся из поведения
            array(
                'idDoctor', 
                'numerical',
                'integerOnly' => true,
                'allowEmpty' => true,
                'message' => WorkDayConst::ID_DOCTOR_IS_NOT_CORRECT_MESSAGE
            ),
            array(
                'idDoctor',
                'exist',
                'allowEmpty' => true,
                'attributeName' => 'id',
                'className' => 'Doctor',
                'message' => WorkDayConst::ID_DOCTOR_IS_NOT_EXIST_MSG
            ),
            /*
            array(
                'idSpecialization', 
                'ext.validators.CompositeUnique',
                'compareWithEmptyStrings' => false,
                'considerNullIsEqualToNull' => true,
                'keyColumns' => array('date', 'idSpecialization', 'idDoctor'),
                'message' => WorkDayConst::DATE_ID_SPECIALIZATION_ID_DOCTOR_IS_NOT_UNIQUE,
            ),
            */
        );
    }

    // Проверяет нужно ли для этой специализации устанавливать врача
    // Ошибка если уставноваливать врача нужно и его нет или
    // установливать врача не нужно, а он установлен
    public function checkRequiredDoctorForThisSpecialization($attribute, $params) {
        if($this->hasErrors() )  {
            return;
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = 'id, needDoctor';
        $result = Specialization::model()->findByPk($this->idSpecialization);
        if ($result->needDoctor) {
            if ($this->idDoctor === null) {
                $this->addError('idDoctor', WorkDayConst::WITH_THIS_SPECIALIZATION_ID_DOCTOR_REQUIERED_MSG);
            }
        } else {
            if ($this->idDoctor !== null) {
                $this->addErorr('idSpecialization', WorkDayConst::WITH_THIS_SPECIALIZATION_ID_DOCTOR_IS_NOT_REQUIERED_MSG); 
            }
        }   
    }

    public function relations()
    {
        return array(
            'specialization' => array(self::BELONGS_TO, 'Specialization', 'idSpecialization'),
            'doctor' => array(self::BELONGS_TO, 'Doctor', 'idDoctor'),
            'time' => array(self::HAS_MANY, 'WorkTime', 'idWorkDay'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'date' => 'Дата',
            'published' => 'Опубликован',
            'idSpecialization' => 'Специализация',
            'idDoctor' => 'Врач',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function deleteTimeById($id) {
        WorkTime::model()->deleteAllByAttributes(array('idWorkDay' => $id) );  
    }
    
    public function deleteTime() {
        self::deleteTimeById($this->id);
    }
    
    public static function updateTimeById($id, $time, $timeStates) {
        //Удаляем старое время
        self::deleteTimeById($id);
        
        //Создаём новое
        for ($i = 0; $i < count($time); $i++) {
            $workTime = new WorkTime();
            $workTime->idWorkDay = $id;
            $workTime->time = TimeFormatHelper::timeShortTextViewToTimeDBView($time[$i]);
            $workTime->state = $timeStates[$i];
            if (!$workTime->save() ) {
                throw new ModifyDBException();
            }  
        } 
    }   
    
    public function updateTime($time, $timeStates) {
        self::updateTimeById($this->id, $time, $timeStates);
    }
    
    public function acceptTemplateWorkDay($templateWorkDay) {
        self::acceptTemplateWorkDayById($this->id, $templateWorkDay);
    }
     
    public static function acceptTemplateWorkDayById($id, $templateWorkDay) {
        //Удаляем старое время
        self::deleteTimeById($id);
        
        //Создаём новое
        foreach($templateWorkDay->time as $t) {
            $workTime = new WorkTime();
            $workTime->idWorkDay = $id;
            $workTime->time = $t->time;
            $workTime->state = $t->state;
            if (!$workTime->save() ) {
                throw new ModifyDBException();
            }
        }
    }  
    
}
