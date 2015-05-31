<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $firstname
 * @property string $surname
 * @property string $patronymic
 * @property string $role
 * @property integer $enabled
 */

Yii::import('constant.validation.UserConst');

class User extends CActiveRecord
{
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_OPERATOR = 'operator';
    
    // Используется при удалении и изменении пользователся
    protected $_previousRole = null;
    
    public function setPreviousRole($value) {
        $this->_previousRole = $value;
    }
    
    
    public function tableName()
    {
        return '{{user}}';
    }
    
    public function rules()
    {
        return array(
            array('name', 'required', 'message' => UserConst::NAME_REQUIERED_MSG),
            array(
                'name', 
                'length', 
                'min' => UserConst::NAME_MIN_LENGTH, 
                'max' => UserConst::NAME_MAX_LENGTH, 
                'tooShort' => UserConst::NAME_TOO_SHORT_MSG,
                'tooLong' => UserConst::NAME_TOO_LONG_MSG,
            ),
            array('name', 'unique', 'message' => UserConst::NAME_IS_NOT_UNIQUE_MSG),
            array('name', 'match', 'pattern' => UserConst::NAME_PATTERN, 'message' => UserConst::NAME_IS_NOT_CORRECT_MSG),
            
            array('password', 'required', 'message' => UserConst::PASSWORD_REQUIERED_MSG),
            array(
                'password', 
                'length', 
                'min' => UserConst::PASSWORD_MIN_LENGTH, 
                'max' => UserConst::PASSWORD_MAX_LENGTH, 
                'tooShort' => UserConst::PASSWORD_TOO_SHORT_MSG,
                'tooLong' => UserConst::PASSWORD_TOO_LONG_MSG,
            ),
          
            array('enabled', 'required', 'message' => UserConst::ENABLED_REQUIERED_MSG),
            array('enabled', 'boolean', 'message' => UserConst::ENABLED_IS_NOT_CORRECT_MSG),
            
            array('role', 'required', 'message' => UserConst::ROLE_REQUIERED_MSG),
            array(
                'role', 
                'in', 
                'range' => array(
                    self::ROLE_OPERATOR,
                    self::ROLE_EDITOR,
                    self::ROLE_ADMIN
                    ),
                'allowEmpty' => false, 
                'message' => UserConst::ROLE_IS_NOT_CORRECT_MSG
            ),
            
            array(
                'firstname', 
                'length', 
                'max' => UserConst::FIRSTNAME_MAX_LENGTH, 
                'tooLong' => UserConst::FIRSTNAME_TOO_LONG_MSG,
            ),
            array('firstname', 'match', 'pattern' => UserConst::FIRSTNAME_PATTERN, 'message' => UserConst::FIRSTNAME_IS_NOT_CORRECT_MSG),
            
            
            array(
                'surname', 
                'length', 
                'max' => UserConst::SURNAME_MAX_LENGTH, 
                'tooLong' => UserConst::SURNAME_TOO_LONG_MSG,
            ),
            array('surname', 'match', 'pattern' => UserConst::SURNAME_PATTERN, 'message' => UserConst::SURNAME_IS_NOT_CORRECT_MSG),
            
            array(
                'patronymic', 
                'length', 
                'max' => UserConst::PATRONYMIC_MAX_LENGTH, 
                'tooLong' => UserConst::PATRONYMIC_TOO_LONG_MSG,
            ),
            array('patronymic', 'match', 'pattern' => UserConst::PATRONYMIC_PATTERN, 'message' => UserConst::PATRONYMIC_IS_NOT_CORRECT_MSG),
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
            'id' => 'id',
            'name' => 'Логин',
            'password' => 'Пароль',
            'firstname' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'role' => 'Роль',
            'enabled' => 'Включён',
        );
    }

   
    public function validatePassword($password) 
    {
        return $password === $this->password;
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function afterSave() {
        parent::afterSave();

        $a = Yii::app()->authManager;
        if (!$this->isNewRecord) {
            // Удаляем старую роль
            $a->revoke($this->_previousRole, $this->id);
        }
        
        if ($this->enabled) {
            // Привязваем роль только если пользователь включён
            $a->assign($this->role, $this->id);
        }
        
        $a->save();
        return true;
    }
	
    public function afterDelete() {
        parent::afterDelete();
        // Убираем связь удаленного пользователя с ролью
        $a = Yii::app()->authManager;
        $a->revoke($this->role, $this->id);
        $a->save();
        return true;
    }

    
}
