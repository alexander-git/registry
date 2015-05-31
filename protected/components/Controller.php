<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    // Важно : везде в проекте подчёркивание перед именем поля используется 
    // только для protected свойств, для которых созданы геттеры и/или сеттеры у объектов
    // унаследованнх от класса CComponenet. Подчёркивание служит не для указания на приватность свойства,
    // а для того чтобы в классе наследнике при обращении к свойству по имени(без подчёркивания) вызывался геттер
    // или сеттер. 
    // Пример : есть поле $a и есть методы getA() и setA(). При выполнени
    // $this->a = 1; в классе наследнике setA вызван не будет - произойдёт просто обращение к
    // полю $a, т.к. свойство protected и нему есть доступ. Поэтому поле нужно назвать $_a. 
    // Такие свойства обязательно должны быть protected, т.к. 
    // с private свойствами "магия" геттеров и сеттеров класса CComponent не работает.
    
    protected $_assetsUrl = null;
    
    // Имя макета, который можно при необходимости отрисовывать из
    // основного (задающегося в $layout).
    protected $_additionalLayout = null;

    public function getAssetsUrl() {
        if ($this->_assetsUrl === null) {
            $this->_assetsUrl = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.assets'),
                false,
                -1,
                true //TODO# В рабочей версии должно быть false.
            );
        }
        return $this->_assetsUrl;
    }
    
    public function getAdditionalLayout() {
        return $this->_additionalLayout;
    }

    public function setAdditionalLayout($additionalLayout) {
        $this->_additionalLayout = $additionalLayout;
    }
            
}