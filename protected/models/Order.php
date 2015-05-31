<?php

/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property integer $id
 * @property integer $idSpecialization
 * @property integer $idDoctor
 * @property string $date
 * @property string $time
 * @property string $firstname
 * @property string $surname
 * @property string $patronymic
 * @property string $phone
 * @property integer $processed
 * @property string $state
 * @property string $orderDateTime
 *
 * The followings are the available model relations:
 * @property Specialization $specialization
 * @property Doctor $doctor
 */

Yii::import('constant.validation.OrderConst');

class Order extends CActiveRecord
{
    const STATE_NOT_DEFINED = 'notDefined';
    const STATE_RESOLVED = 'resolved';
    const STATE_REJECTED = 'rejected';
    
    public function tableName()
    {
        return '{{order}}';
    }

    public function rules()
    {
        return array(
            array('idSpecialization', 'required', 'message' => OrderConst::ID_SPECIALIZATION_REQUIERED_MSG),
            array(
                'idSpecialization', 
                'numerical',
                'integerOnly' => true,
                'message' => OrderConst::ID_SPECIALIZATION_IS_NOT_CORRECT_MSG
            ),
           array(
               'idSpecialization',
               'exist',
               'allowEmpty' => false,
               'attributeName' => 'id',
               'className' => 'Specialization',
               'message' => OrderConst::ID_SPECIALIZATION_IS_NOT_EXIST_MSG
            ),
            
            array(
                'idDoctor', 
                'numerical',
                'integerOnly' => true,
                'allowEmpty' => true,
                'message' => OrderConst::ID_DOCTOR_IS_NOT_CORRECT_MSG
            ),
            array(
                'idDoctor',
                'exist',
                'allowEmpty' => true,
                'attributeName' => 'id',
                'className' => 'Doctor',
                'message' => OrderConst::ID_DOCTOR_IS_NOT_EXIST_MSG
            ),
            
            array('date', 'required', 'message' => OrderConst::DATE_REQUIERED_MSG),
            array('date', 'match', 'pattern' => OrderConst::DATE_PATTERN, 'message' => OrderConst::DATE_IS_NOT_CORRECT_MSG),
            
            array('time', 'required', 'message' => OrderConst::TIME_REQUIERED_MSG),
            array('time', 'match', 'pattern' => OrderConst::TIME_PATTERN, 'message' => OrderConst::TIME_IS_NOT_CORRECT_MSG),
            
            array('orderDateTime', 'required', 'message' => OrderConst::ORDER_DATE_TIME_REQUIRED_MSG ),
            array('orderDateTime', 'match', 'pattern' => OrderConst::ORDER_DATE_TIME_PATTERN, 'message' => OrderConst::ORDER_DATE_TIME_IS_NOT_CORRECT_MSG),
            
            array('firstname', 'required', 'message' => OrderConst::FIRSTNAME_REQUIERED_MSG),
            array(
                'firstname',
                'length',
                'min' => OrderConst::FIRSTNAME_MIN_LENGTH,
                'max' => OrderConst::FIRSTNAME_MAX_LENGTH,
                'tooShort' => OrderConst::FIRSTNAME_TOO_SHORT_MSG,
                'tooLong' => OrderConst::FIRSTNAME_TOO_LONG_MSG
            ),
            array('firstname', 'match', 'pattern' => OrderConst::FIRSTNAME_PATTERN, 'message' => OrderConst::FIRSTNAME_IS_NOT_CORRECT_MSG),

            
            array(
                'surname',
                'length',
                'max' => OrderConst::SURNAME_MAX_LENGTH,
                'tooLong' => OrderConst::SURNAME_TOO_LONG_MSG
            ),
            array('surname', 'match', 'pattern' => OrderConst::SURNAME_PATTERN, 'message' => OrderConst::SURNAME_IS_NOT_CORRECT_MSG),

            array(
                'patronymic',
                'length',
                'allowEmpty' => true,
                'max' => OrderConst::PATRONIMYC_MAX_LENGTH,
                'tooLong' => OrderConst::PATRONYMIC_TOO_LONG_MSG
            ),
            array('patronymic', 'match', 'pattern' => OrderConst::PATRONYMIC_PATTERN, 'message' => OrderConst::PATRONYMIC_IS_NOT_CORRECT_MSG),
            
            // Дополнительная валидация тефлефона(проверку соответствия его определённому шаблону)
            // ппроводится вручную для значения  присланного пользователем на основе настройки из приложения
            // перед занесением этого значения в ActiveRecord и валидациеей
            // котороя проходит с её(ActiveRecord) участием на основе заданных здесь правил.
            // Эта проверка не заданна в правилах валидации по причине того, что настройка может изменится
            // и старые записи Order не будутв этом случае  проходить валидацию. Если при этом 
            // понадобиться изменить что-либо в записи(например имя пользователя), то  сохранить изменения
            // не удасться т.к. старый телефон не пройдёт валидацию. В случае же выниесения валидации 
            // за пределы ActiveRecord всё пройдёт нормально.
            array('phone', 'required', 'message' => OrderConst::PHONE_REQUIERED_MSG),
            array(
                'phone',
                'length',
                'min' => OrderConst::PHONE_MIN_LENGTH,
                'max' => OrderConst::PHONE_MAX_LENGTH,
                'tooShort' => OrderConst::PHONE_TOO_SHORT_MSG,
                'tooLong' => OrderConst::PHONE_TOO_LONG_MSG
            ),
            
            array('processed', 'required', 'message' => OrderConst::PROCESSED_REQUIERED_MSG),
            array('processed', 'boolean', 'message' => OrderConst::PROCESSED_IS_NOT_CORRECT_MSG),
            
            array('state', 'required', 'message' => OrderConst::STATE_REQUIRED_MSG),
            array(
                'state', 
                'in', 
                'range' => array(
                    self::STATE_NOT_DEFINED,
                    self::STATE_RESOLVED,
                    self::STATE_REJECTED
                ),
                'allowEmpty' => false, 
                'message' => OrderConst::STATE_IS_NOT_CORRECT_MSG
            ),
        );
    }


    public function relations()
    {
        return array(
            'specialization' => array(self::BELONGS_TO, 'Specialization', 'idSpecialization'),
            'doctor' => array(self::BELONGS_TO, 'Doctor', 'idDoctor'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'idSpecialization' => 'Специализация ',
            'idDoctor' => 'Врач',
            'date' => 'Дата',
            'time' => 'Время',
            'firstname' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'processed' => 'Обработана',
            'state' => 'Состояние',
            'orderDateTime' => 'Время поступления заявки',
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
                $this->addError('idDoctor', OrderConst::WITH_THIS_SPECIALIZATION_ID_DOCTOR_REQUIERED_MSG);
            }
        } else {
            if ($this->idDoctor !== null) {
                $this->addErorr('idSpecialization', OrderConst::WITH_THIS_SPECIALIZATION_ID_DOCTOR_IS_NOT_REQUIERED_MSG); 
            }
        }    
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
