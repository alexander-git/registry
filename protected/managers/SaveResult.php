<?php

// Используется при возврате результата в методах создающих или изменяющих сущности в базе данных.
// Т.к. в результате их работы в случее непрохождения валидации изменений 
// в базе данных не будет, но ошибки ввода найденные при валидации можно отобразить
// пользователю. 
// Т.е. в случае ошибки $isSuccess === false, а в модели будет установлены ошибки валидации.
// В случае удачного создания $isSuccess === true, а в модели будет заполнено поле id.
class SaveResult extends CComponent {
    
    protected $_model;
    protected $_isSuccess;
    
    public function __construct($model = null, $isSuccess = false) {
        $this->_model = $model;
        $this->_isSuccess = $isSuccess;
    }
    
    public function setIsSuccess($isSuccess) {
        $this->_isSuccess = $isSuccess;
    }
    
    public function getIsSuccess() {
        return $this->_isSuccess;
    }
    
    
    public function setModel($model) {
        $this->_model = $model;
    }
    
    public function getModel() {
        return $this->_model;
    }
    
}
