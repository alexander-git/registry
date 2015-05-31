<?php

Yii::import('zii.widgets.CListView');

class AdminListView extends CListView {
    
    public $htmlOptions = array('class' => 'listView');
    public $template = '{sorter}{items}{pager}';
    public $sorterHeader = 'Сортировка : ';
    public $sorterFooter = '';
    public $itemsTagName = 'div';
    public $itemsCssClass = 'listView__items';
    public $ajaxUpdate = true;
    public $ajaxType = 'POST';
    public $emptyTagName = 'div';
    public $enablePagination = true;
  
    public $beforeAjaxUpdate =
        "
        function(id, data) {
            ListViewHelper.beforeAjaxUpdate(id, data);
        }
        ";
     
    public $afterAjaxUpdate =
        "
        function(id) {
            ListViewHelper.afterAjaxUpdate(id);
        }      
        ";
    
    
    public $ajaxUpdateError = 
        "
        function(xhr, textStatus, errorThrown, errorMessage) {
            ListViewHelper.ajaxUpdateError(xhr, textStatus, errorThrown, errorMessage);
        }
        ";

    
    public function init() {       
        $assetManager = Yii::app()->getAssetManager();
        $assetsDir = dirname(__FILE__).'/assets/adminListView';
        $assetsUrl = $assetManager->publish($assetsDir);
        
        if($this->cssFile === null) {            
            // Подключаем css-файл
           $this->cssFile = $assetsUrl.'/listView.css';    
        }
        // Подключаем js-файл
        Yii::app()->clientScript->registerScriptFile($assetsUrl.'/ListViewHelper.js'); 
        
        
        parent::init();
    }
     
}
