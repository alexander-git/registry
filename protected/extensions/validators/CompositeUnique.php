<?php

class CompositeUnique extends CValidator {
    
    const ONLY_ONE_FIELD_SET_EXCEPTION_MSG = "Для валидации нужно задать больше чем одно поле.";
    
    // Поля входящие в состав уникального ключа
    public $keyColumns;
       
    // Показывать сообщение об ошибке под всеми которые должны быть уникальны
    public $addErrorToAllColumns = false;
    
    // В случае false поля модели с пустыми строками игнорируются
    // при сравнении - сравниваться будут только заполненные поля
    public $compareWithEmptyStrings = true;
    
    // Если $considerNullIsEqualToNull = true то,
    // при проверке строка с такими же значениями проверяемых полей как у объкта, 
    // один или несколько из полей которого равны null, будет считаться равной если у неё
    // значения тех же полей равны NULL (Проверка идёт через IS NULL)
    public $considerNullIsEqualToNull = false;
 
    protected function validateAttribute($object, $attribute) {  
        $class = get_class($object);
         
        // Добавляем в ключ значение атрибута
        $this->keyColumns[] = $attribute;
       
        // И избавляемся от повторяющихся полей
        $this->keyColumns = array_unique($this->keyColumns);
        
        // Если в параметрах одно поле выдать ошибку
        if (count($this->keyColumns) === 1) {
            throw new Exception(self::ONLY_ONE_FIELD_SET_EXCEPTION_MSG);
        }
         
        $criteria = $this->createCriteria($object);
       
        $row = $class::model()->find($criteria);
        // Найдена запись с такими же значениями полей входящих в уникальный ключ
        if ($row !== null) {
            $isNewRecord = $object->isNewRecord;
            $isUpadatingAnotherRecord = false;
            if (!$isNewRecord) {
                $isUpadatingAnotherRecord = $row->getPrimaryKey() !== $object->getPrimaryKey();
            }
            // Создаём новую запись или меняем другую
            if ($isNewRecord || $isUpadatingAnotherRecord) {
                if ($this->addErrorToAllColumns) {
                    foreach ($this->keyColumns as $column) {
                        $this->addError($object, $column, $this->message);
                    }
                } else {
                    $this->addError($object, $attribute, $this->message);
                }
            }
        }    
    }
    
    private function createCriteria($object) {
        $criteria = new CDbCriteria();

        foreach ($this->keyColumns as &$column) {
            if (($this->compareWithEmptyStrings) && ($object->$column === '') ) {  
                // Для полей модели, значение которых равно пустой строке
                // условие для поиска формируем вручную 
                // т.к. CDBCriteria->compae игнорирут пустые строки при 
                // формировании условия
                $criteria->addCondition($column." = '".$object->$column."'", 'AND');
                continue;
            }
            
            if ( ($this->considerNullIsEqualToNull) && ($object->$column === null) )  {
                // Формируем значение condition для полей равных NULL
                $criteria->addCondition($column." IS NULL", 'AND');
                continue;
            }
            
            $criteria->compare($column, $object->$column, false, 'AND');
        }  
        $criteria->limit = 1;
        
        return $criteria;
    }
       
    
}